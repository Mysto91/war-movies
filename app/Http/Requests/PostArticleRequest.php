<?php

namespace App\Http\Requests;

class PostArticleRequest extends ApiFormRequest
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
            'title' => 'required|max:255',
            'description' => 'required',
            'format' => 'present|max:10|in:dvd,blu-ray',
            'rate' => 'present|numeric',
            'trailerUrl' => 'present|url',
            'releaseDate' => 'present|date:Y-m-d',
        ];
    }
}
