<?php

namespace ArtARTs36\EventStat\Tests;

trait WithEnv
{
    protected function loadEnvIfExists(string $path): void
    {
        if (file_exists($path)) {
            $this->loadEnv($path);
        }
    }

    protected function loadEnv(string $path): void
    {
        foreach (file($path) as $setting) {
            if (empty($setting) || $setting === PHP_EOL) {
                continue;
            }

            putenv(trim($setting));
        }
    }
}
