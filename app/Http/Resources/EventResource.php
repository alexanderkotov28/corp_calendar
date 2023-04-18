<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $this->start_date->format('Y-m-d H:i'),
            'end_date' => $this->end_date->format('Y-m-d H:i'),
            'created_at' => $this->whenHas('created_at', fn() => $this->created_at->format('d-m-Y H:i:s')),
            'created_by' => $this->whenLoaded('createdBy', fn() => $this->createdBy->name),
            'users' => $this->whenLoaded('users', fn() => UserResource::collection($this->users)),
            'departments' => $this->whenLoaded('departments', fn() => $this->departments->pluck('id')),
            'description'=> $this->description,
        ];
    }
}
