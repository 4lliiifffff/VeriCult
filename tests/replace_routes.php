<?php
$files = glob('resources/views/pengusul-desa/*-submissions/*.blade.php');
foreach($files as $file) {
    $content = file_get_contents($file);
    $newContent = preg_replace('/pengusul-desa\.(opk|cagar-budaya|potensi)-submissions\.(show|edit|update|destroy|submit|files\.destroy)/', 'pengusul-desa.submissions.$2', $content);
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Replaced in $file\n";
    }
}
