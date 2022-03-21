<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Auth;

interface Auth
{
    public function getHeaders(string $method, string $uri, array $data, array $headers): array;
}
