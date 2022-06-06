<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * App\Models\Article
 *
 * @OA\Schema(
 *      @OA\Property(property="id", type="integer", readOnly="true"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="description", type="string"),
 *      @OA\Property(property="rate", type="string"),
 *      @OA\Property(property="format", type="string", enum={"dvd", "blu-ray"}),
 *      @OA\Property(property="trailerUrl", type="string"),
 *      @OA\Property(property="imageUrl", type="string"),
 *      @OA\Property(property="releaseDate", type="string", format="date"),
 *      @OA\Property(property="createdAt", type="string", readOnly="true", format="date-time"),
 *      @OA\Property(property="updatedAt", type="string", readOnly="true", format="date-time"),
 *      @OA\Property(
 *          property="_links",
 *          type="array",
 *          readOnly=true,
 *          @OA\Items(ref="#/components/schemas/Links")
 *      ),
 * )
 *
 * @property string $title
 * @property string $description
 * @property string $format
 * @property float $rate
 * @property string $trailer_url
 * @property string $image_url
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
        'release_date',
        'image_url',
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
