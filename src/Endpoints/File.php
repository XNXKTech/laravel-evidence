<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;
use XNXK\LaravelEvidence\Traits\BodyAccessorTrait;

class File implements API
{
    use BodyAccessorTrait;

    public const CHECK_ANTFIN_NOTARY = '/v1/checkAntfinNotary';          // 核验签署文件上链信息

    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * 上传待存证的文档
     * 通过上传URL将待存证的文档上传。同时待存证的文档需要以二进制流的方式上传。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Ftg5sby&namespace=opendoc%2Fevidence
     * @param string $url 创建原文存证（基础版/高级版）证据点时获取的上传URL。
     * @param string $contentMd5 内容字节流MD5的Base64编码值，既文件MD5的Base64编码
     * @param string|null $contentType 请求报文数据格式
     * @return void
     */
    public function upload(string $url, string $filePath, string $contentMd5, ?string $contentType = 'application/octet-stream')
    {
        $params = [
            'body' => file_get_contents($filePath),
        ];

        $headers = [
            'Content-Type' => $contentType,
            'Content-MD5' => $contentMd5,
        ];

        $response = $this->adapter->put($url, $params, $headers);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 核验签署文件上链信息
     * 对接方可通过"查询区块链上链信息接口"获取的docHash和antTxHash进行核验上链的信息是否一致，数据是否被篡改。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fzgobhg&namespace=opendoc%2Fevidence
     * @param string $docHash
     * @param string $antTxHash
     * @return void
     */
    public function check(string $docHash, string $antTxHash)
    {
        $params = [
            'docHash' => $docHash,
            'antTxHash' => $antTxHash,
        ];

        $response = $this->adapter->post(self::CHECK_ANTFIN_NOTARY, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }
}
