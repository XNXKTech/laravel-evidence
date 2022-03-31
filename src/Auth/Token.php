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
        if (!array_key_exists('body', $data)) {
            $signatureHeaders['X-timevale-signature'] = evidence()->getSignature(
                json_encode($data),
                $this->secret
            );
        }

        return array_merge($signatureHeaders, $headers);
    }

    public function getHeadersByStandards(string $method, string $uri, array $data, array $headers): array
    {
        if (count($data)) {
            $contentMD5 = $headers && $headers['Content-MD5'] ? $headers['Content-MD5'] : evidence()->getContentMd5(json_encode($data));
        } else {
            $contentMD5 = '';
        }
        $signatureHeaders = [
            'Accept' => '*/*',
            'Content-MD5' => $contentMD5,
            'Content-Type' => 'application/json; charset=UTF-8',
            'X-Tsign-Open-App-Id' => $this->appid,
            'X-Tsign-Open-Ca-Timestamp' =>  evidence()->getMillisecond(),
            'X-Tsign-Open-Auth-Mode' => 'Signature',
        ];
        $signatureHeaders['X-Tsign-Open-Ca-Signature'] = evidence()->getSignatureByStandards(
            strtoupper($method),
            $signatureHeaders['Accept'],
            $signatureHeaders['Content-Type'],
            $signatureHeaders['Content-MD5'],
            '',
            evidence()->getHeadersToString($headers),
            $uri,
            $this->secret
        );

        return array_merge($signatureHeaders, $headers);
    }
}
