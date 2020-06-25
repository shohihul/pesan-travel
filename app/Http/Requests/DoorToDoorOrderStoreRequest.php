<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoorToDoorOrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => ['required', 'numeric'],
            'door_to_door_service_id' => ['required', 'numeric'],
            'pick_up_point' => ['required'],
            'drop_off_point' => ['required'],
            'quantity' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
