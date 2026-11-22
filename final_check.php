<?php
// DMZ egress check
$r = @file_get_contents('https://example.com', false, stream_context_create(array('http' => array('timeout' => 8))));
echo "DMZ egress to example.com: " . ($r === false ? 'BLOCKED' : 'ALLOWED (' . strlen($r) . ' bytes)') . "\n";

foreach (array('web73', 'web82') as $h) {
    $b = @file_get_contents('http://' . $h . '/diagnostic.php');
    echo "$h diagnostic: " . ($b === false ? 'ERR' : strlen($b) . ' bytes') . "\n";
    preg_match_all('~https://(cdnjs|code.jquery|maxcdn|cdn.jsdelivr)[^"\s]+~', (string)$b, $m);
    echo "$h external CDN refs: " . count($m[0]) . "\n";
    $a = @file_get_contents('http://' . $h . '/audit.php');
    echo "$h audit.php (unauth): " . ($a === false ? 'ERR' : trim(substr($a, 0, 40))) . "\n";
}

// Holiday window logic copied from load_settings.php
foreach (array('2026-11-23', '2026-12-25', '2027-01-15', '2027-01-16') as $day) {
    $nd = (int)date('nd', strtotime($day));
    $on = (($nd >= 1225) || ($nd <= 115)) ? 1 : 0;
    echo "$day => MJ_HOLIDAY_SEASON=$on\n";
}
