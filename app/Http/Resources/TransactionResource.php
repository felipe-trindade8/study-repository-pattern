<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'userd_id' => $this->user_id,
            'name' => $this->name,
            'amount' => $this->total_amount,
            'date' => $this->created_at->format('d/m/Y'),
            'card_number' => $this->paymentMethod->card_number_masked,
        ];
    }
}
