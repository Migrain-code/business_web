<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPackageSaleListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'customerName' => $this->customer->name,
           'sellerDate' => $this->formatDate(),
           'serviceName' => $this->service?->subCategory?->getName(),
           'personelName' => $this->personel->name,
           'packageType' => $this->packageType("name"),
           'amount' => $this->amount,
           'usedAmount' => $this->usages->sum('amount'),
           'remainingAmount' => $this->amount - $this->usages->sum('amount'),
           'total' => $this->total. "₺",
           'payedTotal' => $this->payeds->sum('price'),
           'remainingTotal' =>  $this->total - $this->payeds->sum('price')
        ];
    }
}
