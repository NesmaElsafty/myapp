<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\PaginationHelper;
use App\Http\Resources\InputResource;
use App\Models\Input;
use App\Services\InputService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InputController extends Controller
{
    public function __construct(
        protected InputService $inputService
    ) {}

    /**
     * Validation rule for options: one value per option (same for en/ar), with label_en and label_ar.
     * Select/radio: options.choices[] must have value, label_en, label_ar. Checkbox: options must have label_en, label_ar.
     */
    private function optionsRule(?string $type): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($type) {
            if ($value === null || ! is_array($value)) {
                return;
            }
            if (in_array($type, ['select', 'radio'], true)) {
                if (! isset($value['choices']) || ! is_array($value['choices'])) {
                    $fail(__('validation.required', ['attribute' => 'options.choices']));
                    return;
                }
                foreach ($value['choices'] as $index => $choice) {
                    if (! is_array($choice)) {
                        $fail("options.choices.{$index} must be an object with value, label_en, label_ar.");
                        return;
                    }
                    if (empty($choice['value']) || empty($choice['label_en']) || empty($choice['label_ar'])) {
                        $fail("options.choices.{$index} must have value (same for both languages), label_en, and label_ar.");
                    }
                }
                return;
            }
            if ($type === 'checkbox') {
                if (empty($value['label_en']) || empty($value['label_ar'])) {
                    $fail('options must have label_en and label_ar for checkbox type.');
                }
            }
        };
    }

    public function index(Request $request)
    {
        try {
            $lang = app()->getLocale();
            $inputs = $this->inputService->getAll($request->all(), $lang)->paginate(10);

            return response()->json([
                'message' => __('messages.inputs_retrieved_success'),
                'data' => InputResource::collection($inputs),
                'pagination' => PaginationHelper::paginate($inputs),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_inputs'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $input = $this->inputService->getById((int) $id);
            if (!$input) {
                return response()->json(['message' => __('messages.input_not_found')], 404);
            }
            return response()->json([
                'message' => __('messages.input_retrieved_success'),
                'data' => new InputResource($input),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_input'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'screen_id' => 'required|exists:screens,id',
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'placeholder_en' => 'nullable|string|max:255',
                'placeholder_ar' => 'nullable|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'type' => 'nullable|in:text,textarea,select,radio,checkbox,date,time,number,email,phone,url,file,image,video,audio,link',
                'options' => ['nullable', 'array', $this->optionsRule($request->input('type'))],
                'is_required' => 'nullable|boolean',
            ]);

            $input = $this->inputService->create($request->all());

            return response()->json([
                'message' => __('messages.input_created_success'),
                'data' => new InputResource($input->load('screen')),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_create_input'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'screen_id' => 'nullable|exists:screens,id',
                'title_en' => 'nullable|string|max:255',
                'title_ar' => 'nullable|string|max:255',
                'placeholder_en' => 'nullable|string|max:255',
                'placeholder_ar' => 'nullable|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'type' => 'nullable|in:text,textarea,select,radio,checkbox,date,time,number,email,phone,url,file,image,video,audio,link',
                'options' => ['nullable', 'array', $this->optionsRule(
                Input::find($id)?->type ?? $request->input('type')
            )],
                'is_required' => 'nullable|boolean',
            ]);

            $input = $this->inputService->update((int) $id, $request->all());

            return response()->json([
                'message' => __('messages.input_updated_success'),
                'data' => new InputResource($input->load('screen')),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => __('messages.validation_failed'),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_update_input'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->inputService->delete((int) $id);
            return response()->json([
                'message' => __('messages.input_deleted_success'),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => __('messages.input_not_found')], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_delete_input'),
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
