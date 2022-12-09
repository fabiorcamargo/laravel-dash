<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCademiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id ?? '';

        $rules = [
            'name' => 'required|string|max:255|min:3',
            'email' => [
                'required',
                'email',
            ],
            'celular' => [
                'nullable',
                'min:6',
                'max:12',
            ],
            'login_auto' => [
                'required',
            ],
            'gratis' => [
                'required',
            ],
            'criado_em' => [
                'nullable',
            ],
            'visible' => [
                'nullable',
            ],
        ];

        if ($this->method('PUT')) {
           /*
            $rules['password'] = [
                'nullable',
                'min:6',
                'max:15',
            ];
            */
        }

        return $rules;
    }
}