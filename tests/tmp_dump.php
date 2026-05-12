<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check Active Culture again
$submissions = App\Models\CulturalSubmission::where('category', 'Laporan Kebudayaan Aktif')->limit(5)->get();
foreach ($submissions as $s) {
    echo "ID: " . $s->id . " (Aktif)\n";
    echo "Data: " . json_encode($s->category_data, JSON_PRETTY_PRINT) . "\n\n";
}
