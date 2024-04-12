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
            'total' => formatPrice($this->totalServiceAndProduct()),
            'campaignDiscount' => formatPrice($this->calculateCampaignDiscount()),//kampanya indirimi
            'cashPoint' =>  formatPrice($this->point),//kullanılan cash point
            'collectedTotal' => formatPrice($this->calculateCollectedTotal()),//tahsil edilecek tutar
            'remaining_amount' => formatPrice($this->remainingTotal()),//kalan tutar
            'earningPoint' => formatPrice($this->earned_point), //kazanılan parapuan
            'isPermission' => $this->earned_point > 0, //parapuan görünürlük durumu
        ];
    }
    function totalServiceAndProduct(){
        return calculateTotal($this->services) + $this->sales->sum('total');
    }
    public function calculateCampaignDiscount(){ //indirim tl dönüşümü
        $total = (($this->totalServiceAndProduct() * $this->discount) / 100);
        return $total;
    }
    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = $this->totalServiceAndProduct() - $this->calculateCampaignDiscount() - $this->point;
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
