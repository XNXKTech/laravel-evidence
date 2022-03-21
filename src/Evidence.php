<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence;

use Illuminate\Support\Traits\Macroable;
use XNXK\LaravelEvidence\Adapter\Guzzle as Adapter;
use XNXK\LaravelEvidence\Auth\Token;

class Evidence
{
    use Macroable;

    protected Adapter $adapter;
    private Token $token;

    public function __construct(?string $appId = null, ?string $secret = null)
    {
        $token = $appId && $secret ? new Token($appId, $secret) : new Token(env('EVIDENCE_APPID'), env('EVIDENCE_SECRET'));
        $this->adapter = new Adapter($token);
    }
}
