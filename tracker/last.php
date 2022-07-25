<?php
date_default_timezone_set('UTC');
$ttl = 300;

if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    $tag = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
} else {
    $tag = rand(mktime(0, 0, 0, 1, 1, 101), time() - 1); // 60.5 billion
}

if (!apcu_exists((string)$tag)) {
    apcu_store((string)$tag, 1, $ttl);
} else {
    apcu_inc((string)$tag);
}

header('Last-Modified: ' . gmdate("D, d M Y H:i:s T", $tag));
header('Content-Type: text/plain');
echo apcu_fetch((string)$tag);
