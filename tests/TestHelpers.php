<?php

declare(strict_types=1);

namespace Tests;

use XNXK\LaravelEvidence\Evidence;

class TestHelpers extends TestCase
{
    public function __construct()
    {
        parent::setUp();
    }

    /**
     * Helper to easy load an esign test method or the api.
     *
     * @return Evidence
     */
    public function evidence(): Evidence
    {
        return new Evidence();
    }
}
