<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$submissions = \App\Models\CulturalSubmission::whereNull('period_year')->get();
$count = 0;
foreach($submissions as $submission) {
    $submission->period_year = $submission->created_at->year;
    $submission->timestamps = false;
    $submission->save();
    $count++;
}
echo "Fixed $count records!\n";
