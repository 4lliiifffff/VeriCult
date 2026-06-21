<?php
$files = [
    'app/Http/Controllers/PengusulDesa/PotensiSubmissionController.php',
    'app/Http/Controllers/PengusulDesa/OPKSubmissionController.php',
    'app/Http/Controllers/PengusulDesa/CagarBudayaSubmissionController.php'
];
foreach($files as $file) {
    $content = file_get_contents($file);
    $newContent = preg_replace('/pengusul-desa\.(opk|cagar-budaya|potensi)-submissions\.(show|index)/', 'pengusul-desa.submissions.$2', $content);
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Replaced in $file\n";
    }
}
