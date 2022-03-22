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
});
