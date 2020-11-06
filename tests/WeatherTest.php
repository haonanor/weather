<?php
namespace Haonanor\Weather\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Haonanor\Weather\Exceptions\InvalidArgumentException;
use Haonanor\Weather\Weather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase{

    public function testGetWeather(){
// 创建模拟接口响应值。
        $response = new Response(200, [], '<hello>content</hello>');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key' => '4a84d0dac1f29dd0b52f1811bb2a1d71',
                'city' => '深圳',
                'output' => 'xml',
                'extensions' => 'base',
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['4a84d0dac1f29dd0b52f1811bb2a1d71'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame(['success' => true], $w->getWeather('深圳'));
    }

//    public function testGetHttpClient(){
//
//    }
//
//    public function testSetOption(){
//
//    }



//    // 检查 $type 参数
//    public function testGetWeatherWithInvalidType()
//    {
//        $w = new Weather('4a84d0dac1f29dd0b52f1811bb2a1d71');
//
//        // 断言会抛出此异常类
//        $this->expectException(InvalidArgumentException::class);
//
//        // 断言异常消息为 'Invalid type value(base/all): foo'
//        $this->expectExceptionMessage('Invalid type value(base/all): foo');
//
//        $w->getWeather('深圳', 'foo');
//
//        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
//    }
//
//    // 检查 $format 参数
//    public function testGetWeatherWithInvalidFormat()
//    {
//        $w = new Weather('4a84d0dac1f29dd0b52f1811bb2a1d71');
//
//        // 断言会抛出此异常类
//        $this->expectException(InvalidArgumentException::class);
//
//        // 断言异常消息为 'Invalid response format: array'
//        $this->expectExceptionMessage('Invalid response format: array');
//
//        // 因为支持的格式为 xml/json，所以传入 array 会抛出异常
//        $w->getWeather('深圳', 'base', 'array');
//
//        // 如果没有抛出异常，就会运行到这行，标记当前测试没成功
//        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
//    }
}