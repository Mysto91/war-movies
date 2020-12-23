<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $table = 'articles';

    /**
     * Undocumented function
     *
     * @param array $params
     * @return Collection
     */
    public static function getArticleList($params)
    {
        return self::select()
                    ->get();
    }
}
