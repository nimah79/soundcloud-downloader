<?php

/*
 * SoundCloud.com downloader
 * By NimaH79
 * NimaH79.ir
 */

function getSoundcloudDownloadLink($url) {
    $ch = curl_init('https://soundpump.net/download');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('uri' => $url));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    if(!empty($result['downloadUrl'])) return $result['downloadUrl'];
    return false;
}

echo getSoundcloudDownloadLink('https://soundcloud.com/nimsaz/jang-by-shahnazi');