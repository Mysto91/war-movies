<?php

namespace App\Util\Validators;

use App\Models\Article;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Validator;

/**
 *
 */
trait ApiValidator
{
    /**
     * Undocumented function
     *
     * @param array $body
     * @return boolean|Response
     */
    public static function validateStoreArticle($body)
    {
        $validator = Validator::make($body, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return true;
    }

    /**
     * Undocumented function
     *
     * @param array $body
     * @return boolean|Response
     */
    public static function validateUpdateArticle($body)
    {
        $validator = Validator::make($body, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return true;
    }
}
