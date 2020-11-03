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

    public $timestamps = false;

    protected $table = 'stat_event_types';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_SLUG,
    ];

    public static function findBySlug(string $slug): ?self
    {
        return static::query()->where(static::FIELD_SLUG, $slug)->firstOrFail();
    }

    public static function findOrCreate(string $slug): ?self
    {
        $type = static::query()->where(static::FIELD_SLUG, $slug)->first();

        return $type ?? self::store($slug, $slug);
    }

    public static function store(string $title, string $slug): self
    {
        return static::query()->create([
            static::FIELD_TITLE => $title,
            static::FIELD_SLUG => $slug,
        ]);
    }
}
