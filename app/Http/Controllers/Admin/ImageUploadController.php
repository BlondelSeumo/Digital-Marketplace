<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }

        $image = $request->file('image');

        if (!in_array($image->getClientMimeType(), ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'])) {
            return response()->json([
                'error' => translate('Invalid file type. Only image files are allowed (JPEG, JPG, PNG, GIF).'),
            ], 400);
        }

        $settings = @settings('general');

        $imgurExtension = extension('imgur');

        if (!$imgurExtension->status || !@$imgurExtension->settings->client_id) {
            return response()->json([
                'error' => translate('Imgur API Client ID is missing, please setup your client ID in the extensions.'),
            ], 400);
        }

        try {
            $client = new Client();
            $response = $client->request('POST', 'https://api.imgur.com/3/image', [
                'headers' => [
                    'Authorization' => 'Client-ID ' . @$imgurExtension->settings->client_id,
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($image->getRealPath(), 'r'),
                    ],
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 200 && $body['success']) {
                return response()->json([
                    'uploaded' => true,
                    'default' => $body['data']['link'],
                ], 200);
            } else {
                return response()->json([
                    'error' => translate('Failed to upload the image'),
                ], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}