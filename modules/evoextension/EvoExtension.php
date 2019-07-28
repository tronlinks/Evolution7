<?php

namespace modules⁩\⁨eveoextension⁩;

use Twig_Extension;

class EvoExtension extends Twig_Extension
{
    public function getName()
    {
        return "testing";
    }

    public function getFunctions()
    {
        return [new TwigFunction('testfunc', ['modules⁩\⁨eveoextension⁩\EvoExtension','testFunction']),
            new TwigFunction('callAPI', ['modules⁩\⁨eveoextension⁩\EvoExtension','callAPI']),
        ];
        // return array(
        //     new \Twig_SimpleFunction('testfunc', array($this, 'testFunction')),
        // );
        // return [
        //     'testfunc' => new TwigFunction('testfunc', ['modules⁩\⁨eveoextension⁩\EvoExtension', 'testFunction']),
        // ];

        // return [
        //     new \Twig\TwigFunction('testfunc', [$this, 'testFunction']),
        // ];

    }

    public static function testFunction($upperCase = false)
    {
        $string = "the quick brown fox jumps over the lazy dog";
        if ($upperCase == true) {
            return strtoupper($string);
        } else {
            return strtolower($string);
        }
    }

    //get 20 restaurant in Melbourne by call zomato api
    public function callAPI()
    {

        $api = '3dbe310edf1a5430c76aa2bb8928f228';
        $service_url = 'https://developers.zomato.com/api/v2.1/search?entity_id=259&entity_type=city&count=20&apikey=' . $api;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response, true);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }

        return $decoded;
    }

}
