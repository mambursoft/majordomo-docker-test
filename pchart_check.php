<?php
foreach (array('web73', 'web82') as $host) {
$url = 'http://' . $host . '/pChart/analog.php?w=200&h=100&p=ThisComputer.testProp';
$h = @get_headers($url, 1);
echo ($h ? $h[0] : 'NO HEADERS') . "\n";
$b = @file_get_contents($url);
echo 'len=' . strlen((string)$b) . ' first=' . substr((string)$b, 0, 16) . "\n";
echo 'png=' . (substr((string)$b, 0, 8) === "\x89PNG\r\n\x1a\n" ? 'YES' : 'NO') . "\n";
if (substr((string)$b, 0, 1) !== "\x89") {
    echo substr((string)$b, 0, 800) . "\n";
}
}
