<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Adapter;

use Psr\Http\Message\ResponseInterface;
use XNXK\LaravelEvidence\Auth\Auth;

/**
 * Interface Adapter.
 */
interface Adapter
{
    /**
     * Adapter constructor.
     */
    public function __construct(Auth $auth, string $baseURI);

    /**
     * Sends a GET request.
     * Per Robustness Principle - not including the ability to send a body with a GET request (though possible in the
     * RFCs, it is never useful).
     *
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function get(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function put(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface;

    /**
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface;
}
