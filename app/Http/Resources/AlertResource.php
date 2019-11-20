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
            'title_en' => $this->title_en,
            'title_fr' => $this->title_fr,
            'body_en' => $this->body_en,
            'body_fr' => $this->body_fr,
            'color' => $this->color,
            'icon' => $this->icon,
            'can_be_closed' => $this->can_be_closed
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
