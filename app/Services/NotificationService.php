<?php

namespace App\Services;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    public function getAll($filters, $language)
    {
        $query = Notification::query();

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_ar', 'like', "%{$search}%")
                    ->orWhere('content_en', 'like', "%{$search}%")
                    ->orWhere('content_ar', 'like', "%{$search}%");
            });
        }

        if (isset($filters['type']) && $filters['type'] !== 'all') {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['target_type']) && $filters['target_type'] !== 'all') {
            $targetType = $filters['target_type'];
            $query->whereJsonContains('target_type', $targetType);
        }

        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['sorted_by']) && $filters['sorted_by'] !== 'all') {
            switch ($filters['sorted_by']) {
                case 'title':
                    $query->orderBy('title_' . ($filters['language'] ?? 'en'), 'asc');
                    break;
                case 'newest':
                    $query->orderBy('id', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    public function getById($id)
    {
        return Notification::findOrFail($id);
    }

    public function create($data)
    {
        return Notification::create($data);
    }

    public function update($id, $data)
    {
        $notification = $this->getById($id);
        $notification->update($data);
        return $notification->fresh();
    }

    public function delete($id)
    {
        $notification = $this->getById($id);
        return $notification->delete();
    }

    public function updateStatus($id, $status)
    {
        $notification = $this->getById($id);
        $notification->update(['status' => $status]);
        return $notification;
    }

    public function bulkDelete(array $ids)
    {
        return Notification::whereIn('id', $ids)->delete();
    }

    public function export(array $ids)
    {
        return Notification::whereIn('id', $ids)->get();
    }

    /**
     * Get statistics for notifications by status (sent, scheduled, unsent).
     *
     * - Compares current month vs previous month counts.
     * - Generates daily trend data for the current month based on created_at.
     */
    public function stats(): array
    {
        $now = Carbon::now();

        $currentStart = $now->copy()->startOfMonth();
        $currentEnd = $now->copy()->endOfMonth();

        $previousStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $previousEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $statuses = ['sent', 'scheduled', 'unsent'];

        $result = [];

        foreach ($statuses as $status) {
            // Total counts for current and previous month
            $currentCount = Notification::where('status', $status)
                ->whereBetween('created_at', [$currentStart, $currentEnd])
                ->count();

            $previousCount = Notification::where('status', $status)
                ->whereBetween('created_at', [$previousStart, $previousEnd])
                ->count();

            $difference = $currentCount - $previousCount;
            $percentageChange = $previousCount > 0
                ? round(($difference / $previousCount) * 100, 2)
                : null;

            // Trend data for the current month (per day)
            $rawTrend = Notification::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('status', $status)
                ->whereBetween('created_at', [$currentStart, $currentEnd])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray();

            $trend = [];
            $cursor = $currentStart->copy();
            while ($cursor->lte($currentEnd)) {
                $dateKey = $cursor->toDateString();
                $trend[] = [
                    'date' => $dateKey,
                    'count' => isset($rawTrend[$dateKey]) ? (int) $rawTrend[$dateKey] : 0,
                ];
                $cursor->addDay();
            }

            $result[$status] = [
                'current_month' => [
                    'from' => $currentStart->toDateString(),
                    'to' => $currentEnd->toDateString(),
                    'count' => $currentCount,
                ],
                'previous_month' => [
                    'from' => $previousStart->toDateString(),
                    'to' => $previousEnd->toDateString(),
                    'count' => $previousCount,
                ],
                'difference' => $difference,
                'percentage_change' => $percentageChange,
                'trend' => $trend,
            ];
        }

        return $result;
    }
}
