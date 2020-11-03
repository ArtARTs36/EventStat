<?php

namespace ArtARTs36\EventStat\Tests;

use ArtARTs36\EventStat\Providers\EventStatProvider;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithEnv;

    protected const ENV_PATH = __DIR__ . '/../.env';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->loadEnvIfExists(static::ENV_PATH);

        parent::__construct($name, $data, $dataName);
    }

    protected function setUp()
    {
        parent::setUp();

        Schema::dropAllTables();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [
            EventStatProvider::class,
        ];
    }
}
