<?php
foreach (array('web73', 'web82') as $h) {
    $headers = get_headers('http://' . $h . '/audit.php');
    echo "$h audit.php: " . ($headers ? $headers[0] : 'ERR') . "\n";
}
