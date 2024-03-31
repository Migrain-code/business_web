<?php

namespace App\Http\Resources\Adission;

use Illuminate\Http\Resources\Json\JsonResource;

class AdissionDetailResoruce extends JsonResource
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
            'isCampaign' => isset($this->campaign_id),
            'total' => formatPrice($this->total),
            'campaignDiscount' => formatPrice($this->calculateCampaignDiscount()),//kampanya indirimi
            'cashPoint' =>  formatPrice($this->point),//kullanılan cash point
            'collectedTotal' => formatPrice($this->calculateCollectedTotal()),//tahsil edilecek tutar
            'remaining_amount' => formatPrice($this->remainingTotal()),//kalan tutar
            'earningPoint' => formatPrice($this->earned_point), //kazanılan parapuan
            'isPermission' => $this->earned_point > 0, //parapuan görünürlük durumu
        ];
    }
    public function calculateCampaignDiscount(){ //indirim tl dönüşümü
        $total = number_format(($this->total * $this->discount) / 100, 2);
        return $total;
    }
    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = ceil($this->total - ((($this->total * $this->discount) / 100) + $this->point));
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
