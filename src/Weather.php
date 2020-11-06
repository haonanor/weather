<?php
declare(strict_types=1);

namespace Haonanor\Weather;

use GuzzleHttp\Client;
use Haonanor\Weather\Exceptions\HttpException;
use Haonanor\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;
    protected $option = [];

    public function getHttpClient(){
        return new Client($this->option);
    }

    public function setOption(array $option){
        $this->option = $option;
    }

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getWeather($city,string $type='base',string $format = 'json'){
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if(!in_array(strtolower($format),['xml','json'])){
            throw new InvalidArgumentException('无效的参数：'.$format);
        }
        if(!in_array(strtolower($type),['base','all'])){
            throw new InvalidArgumentException('无效类型：'.$type);
        }

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => $format,
            'extensions' =>  $type,
        ]);
        try{
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();
            return 'json' === $format ? \json_decode($response, true) : $response;
        }catch (\Exception $e){
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }



}