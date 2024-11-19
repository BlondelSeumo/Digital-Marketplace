<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function validation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => ['required', 'string'],
            'purchase_code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => translate('error'),
                'msg' => $validator->errors()->first(),
            ], 400);
        }

        if (@settings('api')->key == $request->api_key) {
            $purchase = Purchase::where('code', $request->purchase_code)
                ->active()->with('item')->first();

            if ($purchase) {
                return response()->json([
                    'status' => translate('success'),
                    'item' => new PurchaseResource($purchase),
                ], 200);
            }
        }

        return response()->json([
            'status' => translate('error'),
            'msg' => translate('Invalid purchase code'),
        ], 404);
    }
}