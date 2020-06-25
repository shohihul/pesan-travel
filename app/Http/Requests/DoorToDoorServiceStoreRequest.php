<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoorToDoorServiceStoreRequest extends FormRequest
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
            'car_id' => ['required'],
            'driver_id' => ['required'],
            'origin_id' => ['required'],
            'destination_id' => ['required'],
            'price' => ['required', 'numeric'],
            'start' => ['required','date_format:Y-m-d H:i', 'after:today'],
        ];
    }
}
