<?php

namespace App\Http\Controllers\Api;

use App\Actions\Items\FinalizeItemAction;
use App\Actions\Items\GetScreenInputsAction;
use App\Actions\Items\InitItemAction;
use App\Actions\Items\UpdateItemInputAction;
use App\Actions\Items\DeleteItemInputMediaAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Requests\Items\FinalizeItemRequest;
use App\Http\Requests\Items\InitItemRequest;
use App\Http\Requests\Items\UpdateItemInputRequest;
use App\Http\Requests\Items\DeleteItemInputMediaRequest;
use Illuminate\Http\Request;
use App\Models\Input;
use App\Models\Item;
use App\Models\Screen;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Validation\ValidationException;

class ItemWizardController extends Controller
{
    public function __construct(
        protected InitItemAction $initItemAction,
        protected GetScreenInputsAction $getScreenInputsAction,
        protected UpdateItemInputAction $updateItemInputAction,
        protected FinalizeItemAction $finalizeItemAction,
        protected DeleteItemInputMediaAction $deleteItemInputMediaAction,
    ) {
    }

    public function init(InitItemRequest $request): JsonResponse
    {
        $user = $request->user();

        $result = $this->initItemAction->handle($user, (int) $request->input('category_id'));

        $result['item'] = new ItemResource(
            $result['item']->load(['category', 'city', 'region', 'data.input'])
        );

        return response()->json($result, 201);
    }

    public function showScreen(int $item, int $screen): JsonResponse
    {
        $itemModel = Item::find($item);
        if (! $itemModel) {
            return response()->json([
                'message' => 'Item not found.',
            ], 404);
        }

        $screenModel = Screen::find($screen);
        if (! $screenModel) {
            return response()->json([
                'message' => 'Screen not found.',
            ], 404);
        }

        $this->authorizeOwner($itemModel);

        $result = $this->getScreenInputsAction->handle($itemModel, $screenModel);

        $result['item'] = new ItemResource(
            $itemModel->load(['category', 'city', 'region', 'data.input'])
        );

        return response()->json($result);
    }

    // i want here to update multiple inputs at once
    
    public function updateInput(Request $request): JsonResponse
    {
        $requestData = $request->all();   
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'inputs' => 'required|array',
            'inputs.*id' => 'required|exists:inputs,id',
            'inputs.*value' => 'required|string',
            
        ]);
    //   dd($request->inputs);
        // make dynamic validation rules for the inputs
        foreach ($request->inputs as $input) {
            $inputModel = Input::find($input->id);
            if(isset($inputModel->validation_rules) && !empty($inputModel->validation_rules)) {
            
            $validationRules = implode('|', $inputModel->validation_rules);
                $request->validate([
                    $inputModel->name => $validationRules
                ]);
                $itemModel = Item::find($requestData['item_id']);
                $result = $this->updateItemInputAction->handle($input->value, $itemModel, $inputModel);
            
            }else{
                break;
            }
            
        
        }

        return response()->json([
            'message' => 'Inputs updated successfully.',
            'item' => new ItemResource($itemModel->load(['category', 'city', 'region', 'data.input'])),
        ]);
    }

    public function finalize(FinalizeItemRequest $request, int $item): JsonResponse
    {
        $itemModel = Item::find($item);
        if (! $itemModel) {
            return response()->json([
                'message' => 'Item not found.',
            ], 404);
        }

        $data = $request->validated();

        $itemModel = $this->finalizeItemAction->handle($itemModel, $data);

        return response()->json([
            'item' => new ItemResource(
                $itemModel->load(['category', 'city', 'region', 'data.input'])
            ),
        ]);
    }

    public function deleteMedia(
        DeleteItemInputMediaRequest $request,
        int $item,
        int $input,
        int $media
    ): JsonResponse {
        $itemModel = Item::find($item);
        if (! $itemModel) {
            return response()->json([
                'message' => 'Item not found.',
            ], 404);
        }

        $inputModel = Input::find($input);
        if (! $inputModel) {
            return response()->json([
                'message' => 'Input not found.',
            ], 404);
        }

        $mediaModel = Media::find($media);
        if (! $mediaModel) {
            return response()->json([
                'message' => 'Media not found.',
            ], 404);
        }

        $result = $this->deleteItemInputMediaAction->handle($itemModel, $inputModel, $mediaModel);

        $result['item'] = new ItemResource(
            $itemModel->load(['category', 'city', 'region', 'data.input'])
        );

        return response()->json($result);
    }

    protected function authorizeOwner(Item $item): void
    {
        $user = auth()->user();

        if (! $user || $user->id !== $item->user_id) {
            abort(403, 'You are not allowed to access this item.');
        }
    }
}

