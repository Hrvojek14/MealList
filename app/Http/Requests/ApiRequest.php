<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiRequest extends FormRequest
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
    public function rules()
    {
                
        return [
            'lang' => 'required|alpha',
            'tags.*' => 'numeric',
            'category.*' => 'numeric',
            'diff_time' => 'date',
            'per_page' => 'numeric',
            'page' => 'numeric',
            'with'
        ];
    }
}
