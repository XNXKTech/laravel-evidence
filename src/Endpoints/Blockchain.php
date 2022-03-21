<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;
use XNXK\LaravelEvidence\Traits\BodyAccessorTrait;

class Blockchain implements API
{
    use BodyAccessorTrait;
    
    public const ANT_PUSH_INFO_API = '/evi-service/evidence/v1/blockchain/antPushInfo';                      // 查询区块链上链信息
    public const APPLY_NOTARY_REPORT_API = '/evi-service/evidence/v1/blockchain/applyNotaryReport';          // 申请区块链互联网公证处报告

    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * 查询区块链上链信息
     * 数据存证成功后，e签宝服务端会将创建的原文存证证据点或摘要存证证据点推送上链，对接方可通过该接口查询上链信息。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fwqyeqg&namespace=opendoc%2Fevidence
     * @param string $eid 数据存证编号或创建证据点时返回的 evid
     * @return void
     */
    public function queryAntPushInfo(string $eid)
    {
        $params = [
            'eid' => $eid,
        ];

        $response = $this->adapter->post(self::ANT_PUSH_INFO_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 申请区块链互联网公证处报告
     * 对接方可以通过该接口申请区块链互联网公证处数据存证证明电子版，该存证证明由杭州互联网公证处出具，标准价格20元/份，您可以联系销售经理下单购买。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Ffxfthd&namespace=opendoc%2Fevidence
     * @param string $eid 数据存证编号或创建证据点时返回的 evid
     * @param object $userInfo 用户信息，必填
     * @return void
     */
    public function createApplyNotaryReport(string $eid, object $userInfo)
    {
        $params = [
            'eid' => $eid,
            'userInfo' => $userInfo,
        ];

        $response = $this->adapter->post(self::APPLY_NOTARY_REPORT_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }
}
