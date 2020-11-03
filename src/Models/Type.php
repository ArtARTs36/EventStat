<?php

namespace ArtARTs36\EventStat\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @method static Builder slug(string $slug)
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
        return static::slug($slug)->first();
    }

    public static function findOrStore(string $slug, string $title = null): ?self
    {
        return static::findBySlug($title ?? $slug) ?? static::store($slug, $slug);
    }

    public static function store(string $title, string $slug): self
    {
        return static::query()->create([
            static::FIELD_TITLE => $title,
            static::FIELD_SLUG => $slug,
        ]);
    }

    /**
     * @param Builder $query
     * @param string $slug
     * @return Builder
     */
    public function scopeSlug($query, string $slug)
    {
        return $query
            ->where(static::FIELD_SLUG, $slug)
            ->orderByDesc('id');
    }
}
