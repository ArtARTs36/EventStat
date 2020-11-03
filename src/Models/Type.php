<?php

namespace ArtARTs36\EventStat\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 */
class Type extends Model
{
    public const FIELD_TITLE = 'title';
    public const FIELD_SLUG = 'slug';

    protected $table = 'stat_event_types';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_SLUG,
    ];

    public static function findBySlug(string $slug): ?Type
    {
        return static::query()->where(static::FIELD_SLUG, $slug)->firstOrFail();
    }
}
