<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id'        => $this->id,
                'client_id' => $this->client_id,
                'client'    => $this->client->info,
                'date'      => $this->transaction_date->format('d-m-Y'),
                'amount'    => $this->amount,
        ];
    }
}
