<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * @extends JsonResource<\App\Models\Alert>
 */

class AlertResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'body' => $this->body,
            'color' => $this->color,
            'icon' => $this->icon,
            'action' => $this->action,
            'actionParameters' => $this->action_parameters,
            'image' => basename($this->image),
            'canBeClosed' => $this->can_be_closed,
        ];
    }
}
