<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreRefDataFieldRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('refdatafield_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            'code' => [
                'required',
            ],
            'RDT_key' => [
                'required',
            ],
            'UXType'  => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required'  => 'title is required',
            'code.required'  => 'code is required',
            'RDT_key.required' => 'Reference Data Type Key is required',
            'UXType.required'  => 'UXType is required',
        ];
    }
}
