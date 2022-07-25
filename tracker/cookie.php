<?php
$ttl = 300;
$name = 'id';

if (!empty($_COOKIE[$name])) {
    $tag = $_COOKIE[$name];
} else {
    $tag = md5(mt_rand());
}

if (!apcu_exists($tag)) {
    apcu_store($tag, 1, $ttl);
} else {
    apcu_inc($tag);
}

header("Set-Cookie: {$name}={$tag}; expires=" . gmdate("D, d M Y H:i:s T", time() + $ttl) . ";path=/; domain={$_SERVER['HTTP_HOST']}");
header('Content-Type: text/plain');
echo apcu_fetch($tag);
