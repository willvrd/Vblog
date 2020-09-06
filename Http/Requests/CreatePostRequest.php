<?php

namespace Modules\Vblog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2',
            'summary'=>'required|min:2',
            'description' => 'required|min:2',
            'user_id' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'summary.required' => 'Summary is required',
            'description.required' => 'Description is required',
            'user_id.required' => 'User Id is required',
        ];
    }
}
