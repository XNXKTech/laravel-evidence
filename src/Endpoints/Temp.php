<?php

declare(strict_types=1);

namespace XNXK\LaravelEvidence\Endpoints;

use XNXK\LaravelEvidence\Adapter\Adapter;
use XNXK\LaravelEvidence\Traits\BodyAccessorTrait;

class Temp implements API
{
    use BodyAccessorTrait;

    public const BUS_ADD_API = '/evi-service/evidence/v1/sp/temp/bus/add';                          // 定义所属行业类型
    public const SCENE_ADD_API = '/evi-service/evidence/v1/sp/temp/scene/add';                      // 定义业务凭证（名称）
    public const SEG_ADD_API = '/evi-service/evidence/v1/sp/temp/seg/add';                          // 定义业务凭证中某一证据点名称
    public const SEG_PROP_ADD_API = '/evi-service/evidence/v1/sp/temp/seg-prop/add';                 // 定义业务凭证中某一证据点的字段属性

    private Adapter $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * 定义所属行业类型
     * 新增所属行业类型记录.
     * @link https://open.esign.cn/doc/detail?namespace=opendoc%2Fevidence&id=opendoc%2Fevidence%2Fcya1ge
     * @param array $name 行业名称列表
     * @return void
     */
    public function createBusiness(array $name)
    {
        $params = [
            'name' => $name,
        ];

        $response = $this->adapter->post(self::BUS_ADD_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 定义业务凭证（名称）
     * 新增业务凭证（名称）记录，可理解成证据发生的场景，如房屋租赁合同签署。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fetvam9&namespace=opendoc%2Fevidence
     * @param string $businessTempletId 所属行业类型ID
     * @param array $name 行业签署场景名称列表，如：房屋租赁合同签署
     * @return void
     */
    public function createScene(string $businessTempletId, array $name)
    {
        $params = [
            'businessTempletId' => $businessTempletId,
            'name' => $name,
        ];

        $response = $this->adapter->post(self::SCENE_ADD_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 定义业务凭证中某一证据点名称
     * 新增业务凭证中某一证据点名称记录，可理解成与证据发生时场景有关的信息，如合同签署人信息。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fgoi1ti&namespace=opendoc%2Fevidence
     * @param string $sceneTempletId 业务凭证（名称）ID
     * @param array $name 证据点名称列表
     * @return void
     */
    public function createSeg(string $sceneTempletId, array $name)
    {
        $params = [
            'sceneTempletId' => $sceneTempletId,
            'name' => $name,
        ];

        $response = $this->adapter->post(self::SEG_ADD_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }

    /**
     * 定义业务凭证中某一证据点名称
     * 新增业务凭证中某一证据点的字段属性记录，可理解成将与证据发生时场景有关的信息的字段属性进行设置，以便客户查询存证时能够清晰的观看相关信息，如合同签署人信息的姓名、身份证号、签署短信验证码等。
     * @link https://open.esign.cn/doc/detail?id=opendoc%2Fevidence%2Fqvs3ln&namespace=opendoc%2Fevidence
     * @param string $segmentTempletId 业务凭证中某一证据点名称ID
     * @param array $properties 业务凭证中某一证据点字段属性列表
     * @return void
     */
    public function createSegProp(string $segmentTempletId, array $properties)
    {
        $params = [
            'segmentTempletId' => $segmentTempletId,
            'properties' => $properties,
        ];

        $response = $this->adapter->post(self::SEG_PROP_ADD_API, $params);

        $this->body = json_decode((string) $response->getBody());

        return $this->body;
    }
}
