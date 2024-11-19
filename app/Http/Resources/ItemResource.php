<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category->name,
            'sub_category' => $this->subCategory->name,
            'options' => $this->options,
            'version' => $this->version,
            'demo_link' => $this->demo_link,
            'tags' => $this->tags,
            'media' => [
                'thumbnail' => $this->getThumbnailLink(),
            ],
            'prices' => [
                'regular' => $this->price->regular,
            ],
            'currency' => @settings('currency')->code,
            'last_update_at' => $this->last_update_at,
            'published_at' => $this->created_at,
        ];

        if (!$this->hasExtendedLicense()) {
            $data['prices']['extended'] = $this->price->extended;
        }

        if (!$this->isPreviewFileTypeAudio()) {
            $data['media']['preview_image'] = $this->getPreviewImageLink();
        }

        if ($this->isPreviewFileTypeVideo()) {
            $data['media']['preview_video'] = $this->getPreviewVideoLink();
        }

        if ($this->isPreviewFileTypeAudio()) {
            $data['media']['preview_audio'] = $this->getPreviewAudioLink();
        }

        if ($this->isPreviewFileTypeImage()) {
            $data['media']['screenshots'] = $this->getScreenshotLinks();
        }

        if ($this->isFree()) {
            $data['prices'] = null;
            $data['currency'] = null;
        }

        return $data;
    }
}
