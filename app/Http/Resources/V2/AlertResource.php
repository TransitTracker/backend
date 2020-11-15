<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

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
            'title' => $this->title,
            'body' => $this->body,
            'color' => $this->color,
            'icon' => $this->icon,
            'action' => $this->action,
            'actionParameters' => $this->getTranslation('action_parameters', App::getLocale()),
            'image' => url("storage/{$this->image}"),
            'canBeClosed' => $this->can_be_closed,
        ];
    }
}
