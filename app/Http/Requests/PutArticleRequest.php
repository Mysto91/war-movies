<?php

namespace App\Http\Requests;

use App\Rules\MovieFormat;

class PutArticleRequest extends ApiFormRequest
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
            'title' => 'max:255',
            'description' => 'max:255',
            'format' => new MovieFormat(),
            'rate' => 'numeric',
            'trailerUrl' => 'url',
            'releaseDate' => 'date:Y-m-d',
        ];
    }
}
