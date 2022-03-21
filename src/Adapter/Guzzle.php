<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use XNXK\LaravelEvidence\Auth\Auth;

class Guzzle implements Adapter
{
    private Client $client;
    private Auth $auth;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth, ?string $baseURI = null)
    {
        if ($baseURI === null) {
            $baseURI = 'https://smlcunzheng.tsign.cn:9443/evi-service/evidence';
        }

        $this->auth = $auth;

        $this->client = new Client([
            'base_uri' => $baseURI,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function get(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('get', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('post', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function put(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('put', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('patch', $uri, $data, $headers);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface
    {
        return $this->request('delete', $uri, $data, $headers);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function request(string $method, string $uri, array $data = [], array $headers = [])
    {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            throw new \InvalidArgumentException('Request method must be get, post, put, patch, or delete');
        }

        try {
            $headers = $this->auth->getHeaders($method, $uri, $data, $headers);
            if (array_key_exists('body', $data)) {
                $response = $this->client->$method($uri, [
                    'headers' => $headers,
                    'body' => $data['body'],
                ]);
            } else {
                $response = $this->client->$method($uri, [
                    'headers' => $headers,
                    ($method === 'get' ? 'query' : 'json') => $data ?: null,
                ]);
            }
        } catch (RequestException $err) {
            throw ResponseException::fromRequestException($err);
        }

        return $response;
    }
}
