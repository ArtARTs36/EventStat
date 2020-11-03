<?php

namespace ArtARTs36\EventStat\Tests\Unit;

use ArtARTs36\EventStat\Models\Type;
use ArtARTs36\EventStat\Tests\TestCase;
use Illuminate\Support\Str;

class EventTest extends TestCase
{
    /**
     * @covers \ArtARTs36\EventStat\Models\Type::findBySlug
     */
    public function testFindBySlug(): void
    {
        /** @var Type $type */
        $type = factory(Type::class)->create();

        self::assertNotNull($resp = Type::findBySlug($type->slug));
        self::assertEquals($type->id, $resp->id);

        //

        self::assertNull(Type::findBySlug(Str::random()));
    }

    /**
     * @covers \ArtARTs36\EventStat\Models\Type::store
     */
    public function testStore(): void
    {
        $title = Str::random();
        $slug = Str::random();

        //

        $type = Type::store($title, $slug);

        self::assertEquals($title, $type->title);
        self::assertEquals($slug, $type->slug);
    }
}
