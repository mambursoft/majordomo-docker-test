<?php
$hosts = array('web73', 'web82');
$assets = array(
  '/css/fontawesome-compat.css',
  '/3rdparty/fontawesome/css/all.min.css',
  '/3rdparty/fontawesome/webfonts/fa-solid-900.woff2',
  '/3rdparty/jquery/jquery-3.7.1.min.js',
  '/3rdparty/jquery/jquery-migrate-3.5.0.min.js',
  '/3rdparty/bootstrap/css/bootstrap.min.css',
  '/3rdparty/bootstrap/css/bootstrap-3.4.1.min.css',
  '/3rdparty/bootstrap/js/bootstrap.min.js',
  '/3rdparty/moment/moment-2.31.0.min.js',
  '/3rdparty/moment/moment-2.31.0.min.js.map',
  '/css/holiday.css',
);
foreach ($hosts as $host) {
    echo "=== $host ===\n";
    foreach ($assets as $a) {
        $url = "http://$host$a";
        $h = @get_headers($url, 1);
        $code = is_array($h) && isset($h[0]) ? $h[0] : 'ERR';
        echo "$code $a\n";
    }
    $url = "http://$host/diagnostic.php";
    $ctx = stream_context_create(array('http' => array('timeout' => 20)));
    $body = @file_get_contents($url, false, $ctx);
    echo "diagnostic.php: " . ($body === false ? 'ERR' : strlen($body) . ' bytes') . "\n";
    if ($body !== false) {
        preg_match_all('~https://(cdnjs|code.jquery|maxcdn)[^"\s]+~', $body, $m);
        echo "external CDN refs: " . count($m[0]) . "\n";
        foreach (array_slice($m[0], 0, 5) as $u) { echo "  $u\n"; }
    }
}
