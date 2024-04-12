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

}
