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
     * @return Collection<Article>
     */
    public static function getArticleList($params) : Collection
    {
        return self::select()
                    ->get();
    }
}
