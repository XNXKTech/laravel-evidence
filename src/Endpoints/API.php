<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;

interface API
{
    public function __construct(Adapter $adapter);
}