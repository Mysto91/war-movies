<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rate',
        'format'
    ];

    protected $table = 'articles';

    /**
     * @param array $params
     *
     * @return LengthAwarePaginator
     */
    public static function getArticleList($params): LengthAwarePaginator
    {
        return self::select()
            ->paginate($params['perPage'] ?? 10);
    }
}
