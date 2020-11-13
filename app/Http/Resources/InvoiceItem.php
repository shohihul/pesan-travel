<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $route = $this->doorToDoorOrder->doorToDoorService->origin->name . ' - ' . $this->doorToDoorOrder->doorToDoorService->destination->name;
        $bank_account = $this->bank->bank_account;
        $account_number = $this->bank->account_number;
        $logo = $this->bank->logo;
        
        return [
            'id' => $this->id,
            'route' => $route,
            'service' => $this->service,
            'status' => $this->status,
            'amount' => $this->amount,
            'due_date' => $this->due_date,
            'transfer_to' => $this->transfer_to,
            'bank_account' => $bank_account,
            'account_number' => $account_number,
            'logo' => $logo
        ];
    }
}
