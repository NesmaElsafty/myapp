<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\ContactInfo;
use App\Models\SocialMedia;
use App\Http\Resources\ContactInfoResource;
use App\Http\Resources\SocialMediaResource;

class ContactInfoController extends Controller
{
    //
    // index, update or create contact info
    public function index()
    {
        try {
            $contactInfo = ContactInfo::first();
            $socialMedia = SocialMedia::all();
            return response()->json([
                'message' => __('messages.contact_info_retrieved_success'),
                'data' => [
                    'contact_info' => new ContactInfoResource($contactInfo), 
                    'social_media' => SocialMediaResource::collection($socialMedia),
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => __('messages.failed_retrieve_contact_info'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    // store has update or create contact info
    public function store(Request $request)
    {
            $request->validate([
                'phone' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'copyright' => 'required|string|max:255',
                'social_media' => 'nullable|array',
                'social_media.*.platform' => 'required|string|max:255',
                'social_media.*.url' => 'required|string|max:255',
            ]);
            // dd($request->all());
            $contactInfo = ContactInfo::updateOrCreate
            (['id' => 1], 
                [
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'copyright' => $request->copyright,
                ]
            );

            if($request->has('social_media')) {
                // delete all social media
                SocialMedia::truncate();
                foreach($request->social_media as $media) {
                    SocialMedia::create([
                        'platform' => $media['platform'],
                        'url' => $media['url'],
                    ]);
                }
            }

            $socialMedia = SocialMedia::all();
            
        return response()->json([
            'message' => __('messages.contact_info_updated_success'),
            'data' => [
                'contact_info' => new ContactInfoResource($contactInfo), 
                'social_media' => SocialMediaResource::collection($socialMedia),
            ],
        ], 200);
    }
}
