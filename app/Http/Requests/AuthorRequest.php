<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AuthorRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'There\'s something wrong with your request '. $validator->errors(),

            'data'      => $validator->errors()

        ]));

    }

    public function rules()
    {
        return  [
            'name' => 'required|max:255',
            'birthday' => 'required|date|before:now',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];
    }
}
