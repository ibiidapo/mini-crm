<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
                'id'           => $this->id,
                'first_name'   => $this->first_name,
                'last_name'    => $this->last_name,
                'email'        => $this->email,
                'avatar'       => $this->avatar_path,
                'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
