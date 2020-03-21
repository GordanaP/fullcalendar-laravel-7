<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'start' => $this->start_at,
            'end' => $this->end_at,
            'outcome' => $this->outcome,
            'backgroundColor' => $this->color,
            'borderColor' => $this->color,
            'editable' => $this->is_editable
        ];
    }
}
