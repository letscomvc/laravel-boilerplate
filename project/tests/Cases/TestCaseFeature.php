<?php

namespace Tests\Cases;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->setupDatabase();

        $this->withHeaders([
            'X-CSRF-TOKEN' => csrf_token(),
        ]);
    }

    private function setupDatabase()
    {
        static $seeded = false;

        if (!$seeded) {
            $this->artisan('migrate:fresh');
            $this->artisan('upgrade --dev');
            $this->app[Kernel::class]->setArtisan(null);
            $seeded = true;
        }
    }
}
