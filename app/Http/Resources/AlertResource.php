<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_en' => $this->getTranslation('title', 'en'),
            'title_fr' => $this->getTranslation('title', 'fr'),
            'body_en' => $this->getTranslation('body', 'en'),
            'body_fr' => $this->getTranslation('body', 'fr'),
            'color' => $this->color,
            'icon' => $this->icon,
            'can_be_closed' => $this->can_be_closed,
            'regions' => [],
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'message' => 'OK',
        ];
    }
}
