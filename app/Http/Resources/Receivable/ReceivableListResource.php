<?php

namespace App\Http\Resources\Receivable;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ReceivableListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $paymentDate = Carbon::parse($this->payment_date);

        return [
            'id' => $this->id,
            'customerName' => $this->customer->name,
            'paymentDate' => $paymentDate->format('d.m.Y'),
            'price' => $this->price,
            'status' => $paymentDate < now() ? now()->diffInDays($paymentDate) . " Gün Geçti" : ($this->status == 1 ? "Ödendi" : now()->diffInDays($paymentDate) . " Gün Kaldı"),
            'note' => $this->note,
            'type' => isset($this->appointment_id) ? "Adisyon Ödemesi" : "Borç Ödemesi",
        ];
    }
}
