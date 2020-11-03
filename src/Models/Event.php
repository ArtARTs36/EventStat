<?php

namespace ArtARTs36\EventStat\Models;

use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $entity_type
 * @property int $entity_type_id
 * @property int $type_id
 */
class Event extends Model
{
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_ENTITY_TYPE = 'entity_type';
    public const FIELD_ENTITY_TYPE_ID = 'entity_type_id';
    public const FIELD_TYPE_ID = 'type_id';

    protected $table = 'stat_events';

    protected $fillable = [
        self::FIELD_USER_ID,
        self::FIELD_ENTITY_TYPE,
        self::FIELD_ENTITY_TYPE_ID,
        self::FIELD_TYPE_ID,
    ];

    public static function create(User $user, Model $entity, Type $type): self
    {
        return static::query()->create([
            static::FIELD_USER_ID => $user->id,
            static::FIELD_ENTITY_TYPE => get_class($entity),
            static::FIELD_ENTITY_TYPE_ID => $entity->id,
            static::FIELD_TYPE_ID => $type->id,
        ]);
    }

    public static function isPerformed(User $user, Model $entity, Type $type): bool
    {
        return static::query()
            ->where(static::FIELD_USER_ID, $user->id)
            ->where(static::FIELD_ENTITY_TYPE, get_class($entity))
            ->where(static::FIELD_ENTITY_TYPE_ID, $entity->id)
            ->where(static::FIELD_TYPE_ID, $type->id)
            ->exists();
    }

    public static function isPerformedBySlug(User $user, Model $entity, string $slug): bool
    {
        return static::isPerformed($user, $entity, Type::findBySlug($slug));
    }

    public static function createBySlug(User $user, Model $entity, string $slug): self
    {
        return static::create($user, $entity, Type::findOrCreate($slug));
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
