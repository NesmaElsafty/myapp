<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'phone' => '+966501234567',
            'email' => 'info@example.com',
            'copyright' => '© 2026 All Rights Reserved',
        ]);
    }
}
