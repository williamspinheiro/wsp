<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(empty($this->photo) == false){
            $photo = Storage::disk('public')->url($this->photo);
        } else {
            $photo = asset('img/no_image.png');
        };

        return [
            'id' => $this->id,
            'photo' => $photo,
            'name' => $this->name,
            'profile_id' => $this->profile->name,
            'email' => $this->email,
            'active' => $this->active,
        ];
    }
}
