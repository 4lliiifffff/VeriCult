<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$job = DB::table('failed_jobs')->first();
if ($job) {
    echo "=== FAILED JOB ===\n";
    echo "UUID: " . $job->uuid . "\n";
    echo "Connection: " . $job->connection . "\n";
    echo "Queue: " . $job->queue . "\n";
    echo "Failed at: " . $job->failed_at . "\n\n";
    echo "=== EXCEPTION (first 2000 chars) ===\n";
    echo substr($job->exception, 0, 2000) . "\n";
} else {
    echo "No failed jobs\n";
}
