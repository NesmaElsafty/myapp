<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Http\Resources\CarModelResource;
use App\Models\CarBrand;
use App\Http\Resources\CarBrandResource;
use Exception;
class CarModelController extends Controller
{
    //
    public function getByBrandId($id)
    {
        try {
        
        $carModels = CarModel::where('car_brand_id', $id);
        return response()->json([
            'message' => __('messages.car_models_retrieved_success'),
            'data' => CarModelResource::collection($carModels->get()),
        ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_car_models'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // get all car brands
    public function getAllBrands()
    {
        try {
            $carBrands = CarBrand::all();
            return response()->json([
                'message' => __('messages.car_brands_retrieved_success'),
                'data' => CarBrandResource::collection($carBrands),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_car_brands'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
