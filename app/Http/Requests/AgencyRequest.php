<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'is_active' => 'required',
            'region_id' => 'required',
            'color' => 'required|size:7',
            'text_color' => 'required|size:7',
            'vehicles_type' => 'required',
            'links' => '',
            'static_gtfs_url' => 'required',
            'realtime_method' => 'required',
            'realtime_url' => 'required',
            'realtime_type' => 'required',
            'header_name' => '',
            'header_value' => '',
            'param_name' => '',
            'param_value' => '',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
