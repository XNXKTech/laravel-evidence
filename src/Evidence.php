<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence;

use Illuminate\Support\Traits\Macroable;
use XNXK\LaravelEvidence\Adapter\Guzzle as Adapter;
use XNXK\LaravelEvidence\Auth\Token;
use XNXK\LaravelEvidence\Endpoints\Blockchain;
use XNXK\LaravelEvidence\Endpoints\Report;
use XNXK\LaravelEvidence\Endpoints\Scene;
use XNXK\LaravelEvidence\Endpoints\Temp;

class Evidence
{
    use Macroable;

    protected Adapter $evidence_adapter;
    protected Adapter $esign_adapter;
    private Token $token;

    public function __construct(?string $app_id = null, ?string $secret = null, ?string $evidence_server = null, ?string $esign_server = null)
    {
        $token = $app_id && $secret ? new Token($app_id, $secret) : new Token(env('EVIDENCE_APPID'), env('EVIDENCE_SECRET'));
        $this->evidence_adapter = new Adapter($token, $evidence_server ?: env('EVIDENCE_SERVER'));
        $this->esign_adapter = new Adapter($token, $esign_server ?: env('ESIGN_SERVER'));
    }

    public function temp(): Temp
    {
        return new Temp($this->evidence_adapter);
    }

    public function scene(): Scene
    {
        return new Scene($this->evidence_adapter);
    }

    public function Blockchain(): Blockchain
    {
        return new Blockchain($this->evidence_adapter);
    }

    public function file(): File
    {
        return new File($this->esign_adapter);
    }

    public function report(): Report
    {
        return new Report($this->esign_adapter);
    }
}
