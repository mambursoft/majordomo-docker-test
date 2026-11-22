<?php
$b = @file_get_contents('http://web73/diagnostic.php');
if ($b && preg_match('~<div class="alert alert-danger">(.*?)</div>~s', $b, $m)) {
    echo strip_tags($m[1]) . "\n";
} else {
    echo substr((string)$b, 0, 2000);
}
