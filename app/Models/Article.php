<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * App\Models\Article
 *
 * @property string $title
 * @property string $description
 * @property string $format
 * @property float $rate
 * @property string $trailer_url
 * @property string $release_date
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rate',
        'format',
        'trailer_url',
        'release_date'
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
