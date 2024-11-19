<?php

namespace App\Http\Resources;

use App\Http\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'purchase_code' => $this->code,
            'license_type' => $this->isLicenseTypeRegular() ? translate('Regular') : translate('Extended'),
            'price' => $this->sale->price,
            'currency' => @settings('currency')->code,
            'supported_until' => $this->support_expiry_at ?? null,
            'downloaded' => $this->isDownloaded() ? true : false,
            'purchased_at' => $this->created_at,
            'item' => new ItemResource($this->item),
        ];
    }
}
