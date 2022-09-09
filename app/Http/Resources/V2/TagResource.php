<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Tags>
 */
class TagResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'short_label' => $this->short_label,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'dark_color' => $this->dark_color,
            'text_color' => $this->text_color,
            'dark_text_color' => $this->dark_text_color,
        ];
    }
}
