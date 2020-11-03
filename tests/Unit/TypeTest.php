<?php

namespace ArtARTs36\EventStat\Tests\Unit;

use ArtARTs36\EventStat\Models\Type;
use ArtARTs36\EventStat\Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * @covers \ArtARTs36\EventStat\Models\Type::findBySlug
     */
    public function testIsPerformed(): void
    {
        /** @var Type $type */
        $type = factory(Type::class)->create();

        self::assertNotNull($resp = Type::findBySlug($type->slug));
        self::assertEquals($type->id, $resp->id);
    }
}
