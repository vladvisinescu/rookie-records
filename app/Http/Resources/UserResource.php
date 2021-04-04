<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        return [
            'id' => $data['id'],
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'card_brand' => $this->card_brand,
            'card_four' => $this->card_last_four,
        ];
    }
}
