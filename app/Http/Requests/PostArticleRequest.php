<?php

namespace App\Http\Requests;

use App\Rules\MovieFormat;

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
            'format' => [
                'present',
                new MovieFormat()
            ],
            'rate' => 'present|numeric',
            'trailerUrl' => 'present|url',
            'imageUrl' => 'present|url',
            'releaseDate' => 'present|date:Y-m-d',
        ];
    }
}
