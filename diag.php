<?php
foreach (array('web73', 'web82') as $h) {
    $b = @file_get_contents('http://' . $h . '/diagnostic.php');
    echo "=== $h len=" . strlen((string)$b) . " ===\n" . substr((string)$b, 0, 600) . "\n";
}
