<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarNoteResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'groupId' => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "start" => $this->start_time,
            "end" => $this->end_time,
            "borderColor" => 'white',
            "editable" => false,
            "color" => 'purple',
            "display" => "block",  // auto | block | list-item | background | inverse-background | none
            "url" => url('#')
        ];
    }
}
