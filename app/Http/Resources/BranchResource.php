<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'identifier' => $this->identifier,
            'cnpj' => $this->cnpj,
        ];
    }
}
