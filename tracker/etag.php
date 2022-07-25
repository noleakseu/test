<?php
$ttl = 300;

if (!empty($_SERVER['HTTP_IF_NONE_MATCH'])) {
    $tag = str_replace(array('"', 'W/'), '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH']));
} else {
    $tag = md5(mt_rand());
}

if (!apcu_exists($tag)) {
    apcu_store($tag, 1, $ttl);
} else {
    apcu_inc($tag);
}

header("Etag: \"{$tag}\"");
header('Content-Type: text/plain');
echo apcu_fetch($tag);
