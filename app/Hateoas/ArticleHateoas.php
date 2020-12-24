<?php

namespace App\Hateoas;

use App\Models\Article;
use GDebrauwer\Hateoas\Traits\CreatesLinks;
use Illuminate\Support\Collection;

class ArticleHateoas
{
    use CreatesLinks;

    /**
     * Get the HATEOAS link to view the article.
     *
     * @param Article $article
     *
     * @return null|\GDebrauwer\Hateoas\Link
     */
    public function self(Article $article)
    {
        return $this->link('article.show', ['article' => $article]);
    }

    /**
     * Get the HATEOAS link to delete the article.
     *
     * @param Article $article
     *
     * @return null|\GDebrauwer\Hateoas\Link
     */
    public function delete(Article $article)
    {
        return $this->link('article.destroy', ['article' => $article]);
    }
}
