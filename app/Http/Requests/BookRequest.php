<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookRequest extends FormRequest
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
        return [
            'author_id' => 'required|integer|exists:authors,id',
            'title' => 'required|max:255|min:3',
            'subject' => 'required|max:255|min:3',
            'serial_number' => 'required|max:255|min:3',
            'version_date' => 'required|before:now'
        ];
    }
}
