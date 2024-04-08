<?php

namespace Tests\Cases;

use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Tests\CreatesApplication;

abstract class TestCaseUnit extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->preventSqlQueries();
    }

    private function preventSqlQueries()
    {
        Event::listen(StatementPrepared::class, static function () {
            $message = 'SQL queries are not allowed in unit tests.';
            throw new \Exception($message);
        });
    }
}
