<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class Article extends Model
{
    use HasFactory, Mappable, Eloquence;

    protected $fillable = [
        'title',
        'description',
        'rate',
        'format',
        'trailerUrl'
    ];

    /**
     * @var array $maps
     */
    protected $maps = [
        'trailerUrl' => 'trailer_url'
    ];

    protected $table = 'articles';

    /**
     * Undocumented function
     *
     * @param array $params
     * @return Collection<Article>
     */
    public static function getArticleList($params): Collection
    {
        return self::select()
            ->get();
    }
}
