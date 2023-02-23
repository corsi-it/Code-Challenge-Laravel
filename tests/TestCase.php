<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function floatEquals($actual, $expected): bool
    {
        return bccomp($actual, $expected, 3) == 0;
    }
}
