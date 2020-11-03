<?php

namespace ArtARTs36\EventStat\Models;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $entity_type
 * @property int $entity_id
 * @property int $type_id
 * @property \DateTimeInterface $created_at
 */
class Event extends Model
{
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_ENTITY_TYPE = 'entity_type';
    public const FIELD_ENTITY_ID = 'entity_id';
    public const FIELD_TYPE_ID = 'type_id';

    protected $table = 'stat_events';

    protected $fillable = [
        self::FIELD_USER_ID,
        self::FIELD_ENTITY_TYPE,
        self::FIELD_ENTITY_ID,
        self::FIELD_TYPE_ID,
    ];

    public static function store(User $user, Type $type, Model $entity = null): self
    {
        return static::query()->create(array_merge([
            static::FIELD_USER_ID => $user->id,
            static::FIELD_TYPE_ID => $type->id,
        ], $entity ? [
            static::FIELD_ENTITY_TYPE => get_class($entity),
            static::FIELD_ENTITY_ID => $entity->id,
                ] : [])
        );
    }

    public static function isPerformed(User $user, Type $type, Model $entity = null): bool
    {
        return static::query()
            ->where(static::FIELD_USER_ID, $user->id)
            ->where(static::FIELD_TYPE_ID, $type->id)
            ->when(null !== $entity, function (Builder $query) use ($entity) {
                $query
                    ->where(static::FIELD_ENTITY_TYPE, get_class($entity))
                    ->where(static::FIELD_ENTITY_ID, $entity->id);
            })
            ->exists();
    }

    public static function isPerformedBySlug(User $user, string $slug, Model $entity = null): bool
    {
        return static::isPerformed($user, Type::findBySlug($slug), $entity);
    }

    public static function storeBySlug(User $user, string $slug, Model $entity): self
    {
        return static::store($user, Type::findOrCreate($slug), $entity);
    }

    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

    public function column(string $column): string
    {
        return $this->table . '.' . $column;
    }
}
