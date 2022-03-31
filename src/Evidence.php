<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence;

use Illuminate\Support\Traits\Macroable;
use XNXK\LaravelEvidence\Adapter\Guzzle as Adapter;
use XNXK\LaravelEvidence\Auth\Token;
use XNXK\LaravelEvidence\Endpoints\Blockchain;
use XNXK\LaravelEvidence\Endpoints\File;
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
        $token = $app_id && $secret ? new Token($app_id, $secret) : new Token(getenv('EVIDENCE_APPID'), getenv('EVIDENCE_SECRET'));
        $this->evidence_adapter = new Adapter($token, $evidence_server ?: getenv('EVIDENCE_SERVER'), 'evidence');
        $this->esign_adapter = new Adapter($token, $esign_server ?: getenv('ESIGN_SERVER'), 'esign');
    }

    public function getSignature(
        string $message,
        string $projectSecret
    ): bool|string {
        return hash_hmac('sha256', $message, $projectSecret, false);
    }

    function getSignatureByStandards(
        string $httpMethod,
        string $accept,
        string $contentType,
        string $contentMd5,
        string $date,
        string $headers,
        string $url,
        string $secret
    ): string {
        $stringToSign = $httpMethod . "\n" . $accept . "\n" . $contentMd5 . "\n" . $contentType . "\n" . $date . "\n" . $headers;
        if ($headers !== '') {
            $stringToSign .= "\n" . $url;
        } else {
            $stringToSign .= $url;
        }
        $signature = hash_hmac('sha256', utf8_encode($stringToSign), utf8_encode($secret), true);

        return base64_encode($signature);
    }

    function getHeadersToString(array $headers): string
    {
        if (empty($headers)) {
            return '';
        }

        return str_replace('&', "\n", http_build_query($headers));
    }

    public function getContentMd5($bodyData): string
    {
        return base64_encode(md5($bodyData, true));
    }

    public function getMillisecond(): float
    {
        [$t1, $t2] = explode(' ', microtime());

        return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }

    public function getContentBase64Md5(string $filePath): string
    {
        $md5file = md5_file($filePath, true);

        return base64_encode($md5file);
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
