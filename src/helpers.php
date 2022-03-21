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

if (!function_exists('getContentMd5')) {
    function getContentMd5($bodyData): string
    {
        return base64_encode(md5($bodyData, true));
    }
}

if (!function_exists('getSignature')) {
    function getSignature(
        string $message,
        string $projectSecret
    ): bool|string
    {
        return hash_hmac('sha256', $message, $projectSecret, FALSE);
    }
}

if (!function_exists('getMillisecond')) {
    function getMillisecond(): float
    {
        [$t1, $t2] = explode(' ', microtime());

        return (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
    }
}

if (!function_exists('getContentBase64Md5')) {
    function getContentBase64Md5(string $filePath): string
    {
        $md5file = md5_file($filePath, true);

        return base64_encode($md5file);
    }
}

if (!function_exists('getHeadersToString')) {
    function getHeadersToString(array $headers): string
    {
        if (empty($headers)) {
            return '';
        }

        return str_replace('&', "\n", http_build_query($headers));
    }
}
