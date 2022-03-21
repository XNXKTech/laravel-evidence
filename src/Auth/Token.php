<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Auth;

class Token implements Auth
{
    private string $appid;
    private string $secret;

    public function __construct(string $appid, string $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function getHeaders(string $method, string $uri, array $data, array $headers): array
    {
        $signatureHeaders = [
            'Accept' => '*/*',
            'Content-Type' => 'application/json; charset=UTF-8',
            'X-timevale-project-id' => $this->appid,
            'X-timevale-signature-algorithm' => 'HmacSHA256',
            'X-timevale-mode' => 'package',
        ];
        $signatureHeaders['X-timevale-signature'] = getSignature(
            json_encode($data),
            $this->secret
        );

        return array_merge($signatureHeaders, $headers);
    }
}
