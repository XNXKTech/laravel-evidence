<?php

declare(strict_types=1);

it('create business', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createBusiness(
            [
                '音乐行业',
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeObject();

    foreach ($response->result as $key => $value) {
        putenv('TEST_EVIDENCE_BUSINESS_UUID='.$key);
    }
});

it('create scene', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createScene(
            env('TEST_EVIDENCE_BUSINESS_UUID'),
            [
                '上传音频与歌词的文件'
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeObject();

    foreach ($response->result as $key => $value) {
        putenv('TEST_EVIDENCE_SCENE_UUID='.$key);
    }
});

it('create seg by audio and lyric info', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createSeg(
            env('TEST_EVIDENCE_SCENE_UUID'),
            [
                '音频文件信息',
                '歌词文件信息'
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeObject();

    $uuids = [];
    foreach ($response->result as $key => $value) {
        $uuids[] = $key;
    }
    putenv('TEST_EVIDENCE_SEG_INFO_UUID='.json_encode($uuids));
});

it('create seg by audio info field', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createSegProp(
            json_decode(env('TEST_EVIDENCE_SEG_INFO_UUID'), true)[0],
            [
                [
                    'displayName' => '作品名',
                    'paramName' => 'name',
                ],
                [
                    'displayName' => '作曲',
                    'paramName' => 'composer',
                ],
                [
                    'displayName' => '文件链接',
                    'paramName' => 'fileUrl',
                ],
                [
                    'displayName' => 'SHA-1',
                    'paramName' => 'sha1',
                ],
                [
                    'displayName' => 'SHA-256',
                    'paramName' => 'sha256',
                ],
                [
                    'displayName' => 'SHA-512',
                    'paramName' => 'sha512',
                ]
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeArray();
});

it('create seg by lyric info field', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->temp()
        ->createSegProp(
            json_decode(env('TEST_EVIDENCE_SEG_INFO_UUID'), true)[1],
            [
                [
                    'displayName' => '作品名',
                    'paramName' => 'name',
                ],
                [
                    'displayName' => '作词',
                    'paramName' => 'lyricist',
                ],
                [
                    'displayName' => '文件链接',
                    'paramName' => 'fileUrl',
                ],
                [
                    'displayName' => 'SHA-1',
                    'paramName' => 'sha1',
                ],
                [
                    'displayName' => 'SHA-256',
                    'paramName' => 'sha256',
                ],
                [
                    'displayName' => 'SHA-512',
                    'paramName' => 'sha512',
                ]
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->result)->toBeArray();
});

it('create voucher', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->Scene()
        ->createVoucher(
            '词曲版权证据链',
            env('TEST_EVIDENCE_SCENE_UUID'),
        );

    expect($response->errCode)->toEqual(0);
    expect($response->evid)->toBeString();

    putenv('TEST_EVIDENCE_EVID='.$response->evid);
});

it('create segment original by standard in audio', function () {
    $filePath = dirname(__DIR__) . '/Public/demo.mp3';
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->scene()
        ->createSegmentOriginalByStandard(
            json_decode(env('TEST_EVIDENCE_SEG_INFO_UUID'), true)[0],
            json_encode([
                'name' => 'demo',
                'composer' => '周杰伦',
                'fileUrl' => 'https://www.music.com/file/demo.mp3',
                'sha1' => hash_file('sha1', $filePath),
                'sha256' => hash_file('sha256', $filePath),
                'sha512' => hash_file('sha512', $filePath)
            ]),
            [
                'contentDescription' => basename($filePath),
                'contentLength' => filesize($filePath),
                'contentBase64Md5' => getContentBase64Md5($filePath)
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->evid)->toBeString();
    expect($response->url)->toBeString();

    putenv('TEST_EVIDENCE_AUDIO_EVID='.$response->evid);
    putenv('TEST_EVIDENCE_UPLOAD_AUDIO_URL='.$response->url);
});

it('create segment original by standard in lyric', function () {
    $filePath = dirname(__DIR__) . '/Public/demo.txt';
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->scene()
        ->createSegmentOriginalByStandard(
            json_decode(env('TEST_EVIDENCE_SEG_INFO_UUID'), true)[1],
            json_encode([
                'name' => 'demo',
                'lyricist' => '周杰伦',
                'fileUrl' => 'https://www.music.com/file/demo.txt',
                'sha1' => hash_file('sha1', $filePath),
                'sha256' => hash_file('sha256', $filePath),
                'sha512' => hash_file('sha512', $filePath)
            ]),
            [
                'contentDescription' => basename($filePath),
                'contentLength' => filesize($filePath),
                'contentBase64Md5' => getContentBase64Md5($filePath)
            ]
        );

    expect($response->errCode)->toEqual(0);
    expect($response->evid)->toBeString();

    putenv('TEST_EVIDENCE_LYRIC_EVID='.$response->evid);
    putenv('TEST_EVIDENCE_UPLOAD_LYRIC_URL='.$response->url);
});

it('upload audio file', function () {
    $filePath = dirname(__DIR__) . '/Public/demo.mp3';
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->file()
        ->upload(
            env('TEST_EVIDENCE_UPLOAD_AUDIO_URL'),
            $filePath,
            getContentBase64Md5($filePath)
        );

    expect($response->errCode)->toEqual(0);
});

it('upload lyric file', function () {
    $filePath = dirname(__DIR__) . '/Public/demo.txt';
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->file()
        ->upload(
            env('TEST_EVIDENCE_UPLOAD_LYRIC_URL'),
            $filePath,
            getContentBase64Md5($filePath)
        );

    expect($response->errCode)->toEqual(0);
});

it('create append audio and lyric', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->scene()
        ->createAppend(
            env('TEST_EVIDENCE_EVID'),
            [
                [
                    'type' => '0',
                    'value' => env('TEST_EVIDENCE_AUDIO_EVID')
                ],
                [
                    'type' => '0',
                    'value' => env('TEST_EVIDENCE_LYRIC_EVID')
                ]
            ]
        );

    expect($response->errCode)->toEqual(0);
});

it('create relate', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->scene()
        ->createRelate(
            env('TEST_EVIDENCE_EVID'),
            [
                [
                    'type' => 'ID_CARD',
                    'number' => '440301197110292910',
                    'name' => '马化腾'
                ]
            ]
        );

    expect($response->errCode)->toEqual(0);
});

it('query certificate info url', function () {
    $response = app(Tests\TestHelpers::class)
        ->evidence()
        ->scene()
        ->queryCertificateInfoUrl(
            env('TEST_EVIDENCE_EVID'),
            (int) getMillisecond(),
            false,
            'ID_CARD',
            '440301197110292910'
        );

    expect($response->errCode)->toEqual(0);
    expect($response->url)->toBeString();
});