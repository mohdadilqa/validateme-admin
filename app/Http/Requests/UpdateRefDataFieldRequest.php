<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRefDataFieldRequest extends FormRequest
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
            'field_type'  => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required'  => 'Title is required',
            'code.required'  => 'Code is required',
            'RDT_key.required' => 'Reference Data Type Key is required',
            'field_type.required'  => 'Field type is required',
        ];
    }
}
