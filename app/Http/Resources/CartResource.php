<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title' => $this['title'],
            'price' => $this['price'],
            'quantity' => $this['quantity'],
            'image_url' => $this['image_url'],
        ];
    }
}
