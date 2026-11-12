<?php

namespace Tests;

use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        SiteSettings::flush();
    }
}
