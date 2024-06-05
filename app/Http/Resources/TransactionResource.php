<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_email' => $this->customer_email,
            'reference_number' => $this->reference_number,
            'amount' => $this->amount,
            'status' => $this->status,
            'token' => $this->token,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
