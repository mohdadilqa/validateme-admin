<?php

namespace App\Http\Requests;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreDocTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('doctype_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
            ],
            'ref_data_field' => [
                'required',
            ],
            'name_rule' => [
                'required',
            ],
            'category'  => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'Document name is required',
            'ref_data_field.required'  => 'Reference field is required',
            'name_rule.required' => 'Name rule can not be empty',
            'category.required'  => 'Category is required',
        ];
    }
}
