<?php

declare(strict_types=1);

use XNXK\LaravelEvidence\Evidence;

if (!function_exists('Evidence')) {
    /**
     * Helper to easy load an esign method or the api.
     *
     * @param  string|null  $method esign method name
     */
    function evidence(?string $method = null): Evidence
    {
        $evidence = app(Evidence::class);

        return $method ? $evidence->load($method) : $evidence;
    }
}
