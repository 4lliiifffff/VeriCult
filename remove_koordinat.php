<?php
$content = file_get_contents(__DIR__ . '/config/category_fields.php');
$content = preg_replace('/\s*\'koordinat[^\']*\'\s*=>\s*\[(?:[^\]]*?\[[^\]]*?\])*[^\]]*?\],/s', '', $content);
file_put_contents(__DIR__ . '/config/category_fields.php', $content);
echo "Replaced\n";
