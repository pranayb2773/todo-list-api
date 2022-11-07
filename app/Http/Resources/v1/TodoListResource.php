<?php

namespace App\Http\Resources\v1;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin TodoList
 */
class TodoListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'status' => $this->status->name,
            'priority' => $this->priority->name,
            'user_id' => $this->user_id,
            'user' => UserResource::collection($this->whenLoaded('user')),
            'tags' => TagResource::collection($this->tags)
        ];
    }
}
