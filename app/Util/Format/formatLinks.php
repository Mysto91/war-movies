<?php

namespace App\Util\Format;

/**
 *
 */
trait formatLinks
{
    /**
     *
     * @param string $rel
     * @param string $method
     * @param string $path
     * @return array
     */
    public static function link($rel, $method, $path): array
    {
        return [
            'rel' => $rel,
            'type' => $method,
            'href' => env('APP_URL') . '/' . $path
        ];
    }

    /**
     *
     * @param string $path
     * @param integer|null $id
     *
     * @return array
     */
    public static function links($path, $id = null): array
    {
        $pathId = basename($path);
        $selfPath = $path;

        if (is_numeric($pathId)) {
            $selfPath = $path;
            $path = str_replace('/' . $id, '', $path);
        } else {
            $selfPath = $path . '/' . $id;
        }

        return [
            self::link('self', 'GET', $selfPath),
            self::link('list', 'GET', $path)
        ];
    }
}
