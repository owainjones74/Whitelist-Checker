<?php
$APIKey = "RqZoI2ORt0E6eY7SwF372OImQMTkqTGHpuboh8va";
require_once("../lib/cache.class.php");
$cache = new Cache();

function GetWhitelists($team) {
    global $APIKey;

    $agent = 'Whitelist Job Checker';
    $url = "http://api.thexyznetwork.xyz/policerp/whitelists/$team";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'apikey: ' . $APIKey,
    ));

    if(!$response = curl_exec($ch))
        echo curl_error($ch);

    curl_close($ch);
    $response = json_decode($response);

    if (!$response->result) {
        return NULL;
    }

    return array_slice($response->result->users, 0, 200);
}

function GetName($id) {
    global $APIKey;
    global $cache;

    $cache->setCache($id);

    $result = $cache->retrieve('name');

    try {
        if (!$result) {
            $agent = 'Whitelist Job Checker';
            $url = "http://api.thexyznetwork.xyz/policerp/users/$id";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'apikey: ' . $APIKey,
            ));

            if(!$response = curl_exec($ch))
                echo curl_error($ch);

            curl_close($ch);
            $response = json_decode($response);

            if (!$response->result) {
                return "Unknown";
            }

            $cache->store("name", $response->result->rpname, 60*60);
        };

        // Return the cache data
        return $cache->retrieve('name');
    } catch (Exception $e) {
        return "Unknown";
    }
}

function GetActivity($id, $job) {
    global $APIKey;
    global $cache;

    $cache->setCache($id);

    $result = $cache->retrieve('activity:' . $job);

    try {
        if (!$result) {
            $agent = 'Whitelist Job Checker';
            $url = "http://api.thexyznetwork.xyz/policerp/jobtracker/$id/$job";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'apikey: ' . $APIKey,
            ));

            if(!$response = curl_exec($ch))
                echo curl_error($ch);

            curl_close($ch);
            $response = json_decode($response);

            if (!$response->result) {
                return NULL;
            }
            if (empty($response->result->entries)) {
                return NULL;
            }

            $cache->store('activity:' . $job, $response->result->entries, 60*60);
        };

        // Return the cache data
        return $cache->retrieve('activity:' . $job);
    } catch (Exception $e) {
        return NULL;
    }
}
