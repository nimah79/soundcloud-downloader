<?php

/*
 * SoundCloud.com downloader
 * By NimaH79
 * NimaH79.ir
 */

class SoundCloud
{

    private static $domain = 'dlnowsoft.com';
    private static $scheme = 'https://';

    public function getDownloadURL($url)
    {
        $subdomain_and_id = self::getSubdomainAndId();
        $data = self::curl_get_contents(self::$scheme.$subdomain_and_id['subdomain'].'.'.self::$domain.'/get-json.php?'.http_build_query(['url' => $url, 'id' => $subdomain_and_id['id']]));
        if(strpos($data, 'Error') !== false) {
            return $data;
        }
        $data = json_decode($data, true);
        
        return isset($data['url']) ? $data['url'] : false;
    }

    private static function getSubdomainAndId() {
        $page = self::curl_get_contents(self::$scheme.'www.'.self::$domain.'/soundcloud-mp3');
        preg_match('/(\w+)\.dlnowsoft\.com\/g/', $page, $subdomain);
        preg_match('/"&id=","(.*?)"/', $page, $id);

        return ['subdomain' => $subdomain[1], 'id' => $id[1]];
    }

    private static function curl_get_contents($url, $parameters = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}
