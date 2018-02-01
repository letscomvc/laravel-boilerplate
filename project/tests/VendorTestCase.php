<?php

namespace Tests;

abstract class VendorTestCase extends TestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();
    }
}
