<?php

declare(strict_types=1);

it('create business', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createBusiness(
            [
                '房屋租赁行业',
                '音乐行业',
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeObject();

    foreach ($response->result as $key => $value) {
        putenv('TEST_EVIDENCE_TEMP_UUID='.$key);
    }
});

it('create scene', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createScene(
            env('TEST_EVIDENCE_TEMP_UUID'),
            [
                '音乐行业'
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeObject();
});
