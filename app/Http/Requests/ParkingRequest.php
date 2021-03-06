<?php

namespace App\Http\Requests;

use App\Rules\LocationCoordinates;
use Illuminate\Foundation\Http\FormRequest;

class ParkingRequest extends FormRequest
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
//            'latitude' => new LocationCoordinates(),
//            'longitude' => new LocationCoordinates(),
            'radius' => [
                'required'
            ]
        ];
    }
}
