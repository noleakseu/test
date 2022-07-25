<?php
$ttl = 300;
$name = 'id';

if (!empty($_GET[$name])) {
    $tag = $_GET[$name];
    if (!apcu_exists($tag)) {
        apcu_store($tag, 1, $ttl);
    } else {
        apcu_inc($tag);
    }
    header('Content-Type: text/plain');
    print_r(apcu_fetch($tag));
    exit;
}

$tag = md5(mt_rand());
header("HTTP/1.1 301 Moved Permanently");
header("Location: /redirect.php?{$name}={$tag}");
