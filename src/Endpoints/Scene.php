<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;
use XNXK\LaravelEvidence\Traits\BodyAccessorTrait;

class Scene implements API
{
    use BodyAccessorTrait;

    public const VOUCHER_API = '/evi-service/evidence/v1/sp/scene/voucher';                         // 创建证据链
    public const ORIGINAL_STANDARD_API = '/evi-service/evidence/v1/sp/segment/original-std/url';    // 创建原文存证（基础版）证据点
    public const ORIGINAL_ADVANCED_API = '/evi-service/evidence/v1/sp/segment/original-adv/url';    // 创建原文存证（高级版）证据点
    public const ORIGINAL_DIGEST_API = '/evi-service/evidence/v1/sp/segment/abstract/url';          // 创建摘要存证证据点
    public const VOUCHER_APPEND_API = '/evi-service/evidence/v1/sp/scene/append';                   // 追加证据点
    public const RELATE_API = '/evi-service/evidence/v1/sp/scene/relate';                           // 数据存证编号关联到指定用户
    public const CERTIFICATE_INFO_URL_API = '/evi-service/evidence/v1/sp/scene/getUrl';             // 获取用于查看存证证明的跳转URL

    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * 创建证据链
     * 新增一条证据链记录，并获取数据存证编号，以便后期向该条证据链中继续追加证据点。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fhcwhga&namespace=opendoc%2Fevidence
     * @param string $sceneName 数据存证名称
     * @param string $sceneTemplateId 业务凭证（名称）ID
     * @param array|null $linkIds 证据 Ids
     * @return void
     */
    public function createVoucher(string $sceneName, string $sceneTemplateId, ?array $linkIds = [])
    {
        $params = [
            'sceneName' => $sceneName,
            'sceneTemplateId' => $sceneTemplateId,
            'linkIds' => $linkIds,
        ];

        $response = $this->adapter->post(self::VOUCHER_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 创建原文存证（基础版）证据点
     * 原文存证基础版存证成功后将原文同时推送到e签宝服务端和司法鉴定中心（全称：国家信息中心电子数据司法鉴定中心）,不会推送到公证处。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Flubfh7&namespace=opendoc%2Fevidence
     * @param string $segmentTempletId 业务凭证中某一证据点名称ID
     * @param string $segmentData JSON字符串格式的业务数据，其中所有key值必须为环节属性模板表中对应环节模板记录的paramName字段的值与content字段不可同时为空
     * @param array|null $content 原文信息，包含contentDescription、contentLength、contentBase64Md5二级属性，与segmentData字段不可同时为空
     * @return void
     */
    public function createSegmentOriginalByStandard(string $segmentTempletId, string $segmentData, ?array $content)
    {
        $params = [
            'segmentTempletId' => $segmentTempletId,
            'segmentData' => $segmentData,
            'content' => $content,
        ];

        $response = $this->adapter->post(self::ORIGINAL_STANDARD_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 创建原文存证（高级版）证据点
     * 原文存证存证成功后将原文同时推送到e签宝服务端，原文的摘要(SHA256)推送到司法鉴定中心（全称：国家信息中心电子数据司法鉴定中心）、蚂蚁区块链和公证处。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fugnigk&namespace=opendoc%2Fevidence
     * @param string $segmentTempletId 业务凭证中某一证据点名称ID
     * @param string $segmentData JSON字符串格式的业务数据，其中所有key值必须为环节属性模板表中对应环节模板记录的paramName字段的值。注：该字段与content字段不可同时为空。
     * @param object|null $content 原文信息，包含contentDescription、contentLength、contentBase64Md5二级属性，与segmentData字段不可同时为空
     * @return void
     */
    public function createSegmentOriginalByAdvanced(string $segmentTempletId, string $segmentData, ?object $content)
    {
        $params = [
            'segmentTempletId' => $segmentTempletId,
            'segmentData' => $segmentData,
            'content' => $content,
        ];

        $response = $this->adapter->post(self::ORIGINAL_ADVANCED_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 创建摘要存证证据点
     * 摘要版存证不会将原文进行推送,仅是将原文的摘要(SHA256)推送到e签宝服务端、司法鉴定中心（全称：国家信息中心电子数据司法鉴定中心）、蚂蚁区块链和公证处。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fwi7zqt&namespace=opendoc%2Fevidence
     * @param string $segmentTempletId 业务凭证中某一证据点名称ID
     * @param string $segmentData JSON字符串格式的业务数据，其中所有key值必须为环节属性模板表中对应环节模板记录的paramName字段的值。注：该字段与content字段不可同时为空。
     * @param array|null $content 原文信息，包含contentDescription、contentLength、contentBase64Md5二级属性，与segmentData字段不可同时为空
     * @return void
     */
    public function createSegmentOriginalAbstract(string $segmentTempletId, string $segmentData, ?array $content)
    {
        $params = [
            'segmentTempletId' => $segmentTempletId,
            'segmentData' => $segmentData,
            'content' => $content,
        ];
        
        $response = $this->adapter->post(self::ORIGINAL_DIGEST_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 追加证据点
     * 将证据点追加到已存在的证据链内形成证据链。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fseqhe0&namespace=opendoc%2Fevidence
     * @param string $evid 数据存证编号
     * @param array|null $linkIds 证据 Ids
     * @return void
     */
    public function createAppend(string $evid, ?array $linkIds)
    {
        $params = [
            'evid' => $evid,
            'linkIds' => $linkIds,
        ];

        $response = $this->adapter->post(self::VOUCHER_APPEND_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 数据存证编号关联到指定用户
     * 将数据存证编号与用户的证件号进行关联后，在需要出证时该用户可登录e签宝官网进行在线申请。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fzdcrz7&namespace=opendoc%2Fevidence
     * @param string $evid 数据存证编号
     * @param array $certificates 用户证件信息，Certificate类型list
     * @return void
     */
    public function createRelate(string $evid, array $certificates)
    {
        $params = [
            'evid' => $evid,
            'certificates' => $certificates,
        ];

        $response = $this->adapter->post(self::RELATE_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 获取用于查看存证证明的跳转URL
     * 数据存证成功后可以通过接口获取存证证明查看链接。该接口和 拼接用于查看存证证明的跳转URL 方式区别在于该接口生成的存证证明查看链接中不包含敏感。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fzdcrz7&namespace=opendoc%2Fevidence
     * @param string $id 数据存证编号，证据链id
     * @param int $timestamp 时间戳（毫秒级）
     * @param bool $reverse Url访问地址的有效期，true表示timestamp字段为链接的失效时间，false表示timestamp字段为链接的生效时间
     * @param string $type 证件类型
     * @param string $number 证件号码
     * @return void
     */
    public function queryCertificateInfoUrl(string $id, int $timestamp, bool $reverse, string $type, string $number)
    {
        $params = [
            'id' => $id,
            'timestamp' => $timestamp,
            'reverse' => $reverse,
            'type' => $type,
            'number' => $number
        ];

        $response = $this->adapter->post(self::CERTIFICATE_INFO_URL_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }
}
