<?php

declare(strict_types=1);

namespace XNXK\LaravelEsign\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;
use XNXK\LaravelEvidence\Traits\BodyAccessorTrait;

class Report implements API
{
    use BodyAccessorTrait;

    public const ISSUE_REPORT_APPLY_API = '/v1/bridge/issueReport/apply';          // 申请数据存证证明
    public const ISSUE_REPORT_QUERY_API = '/v1/bridge/issueReport/query';          // 查询数据存证出证记录

    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * 查询数据存证出证记录
     * 通过调用”申请数据存证证明”接口申请存证证明后，如果长时间未收到回调，可通过此接口查询出证状态及对应的下载地址。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fqnbzod&namespace=opendoc%2Fevidence
     * @param string $reportId 消息 id（”申请数据存证证明”接口返回）
     * @return void
     */
    public function query(string $reportId)
    {
        $params = [
            'reportId' => $reportId
        ];

        $response = $this->adapter->post(self::ISSUE_REPORT_APPLY_API, $params);

        $this->body = json_decode((string)$response->getBody());

        return $this->body;
    }

    /**
     * 申请数据存证证明
     * 可通过该接口申请”e签宝数据存证证明“电子版下载地址，该存证证明由e签宝出具，暂不收取费用。
     * 注意：接口为异步出证，出证成功后，会通过回调地址返回存证证明与证据包下载地址。（回调地址请提供appId并联系e签宝服务人员进行配置）
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Ftgbgzq&namespace=opendoc%2Fevidence
     * @param string $eid 数据存证编号
     * @param string $number 证据持有者证件号
     * @param string|null $type 证据持有者证件类型
     * @return void
     */
    public function create(string $eid, string $number, ?string $type = 'ID_CARD')
    {
        $params = [
            'eid' => $eid,
            'type' => $type,
            'number' => $number
        ];

        $response = $this->adapter->post(self::ISSUE_REPORT_QUERY_API, $params);

        $this->body = json_decode((string)$response->getBody());

        return $this->body;
    }
}