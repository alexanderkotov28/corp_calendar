<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'department_id' => $this->department_id,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'department' => $this->whenLoaded('department', function () {
                return $this->department->title;
            }),
        ];
    }
}
