<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('cultural_submissions')
            ->where('category', 'Laporan Kebudayaan Aktif')
            ->chunkById(100, function ($submissions) {
                foreach ($submissions as $submission) {
                    if (empty($submission->category_data)) {
                        continue;
                    }

                    $data = json_decode($submission->category_data, true);
                    if (!is_array($data)) {
                        continue;
                    }

                    $newData = [];
                    $mappings = [
                        'apa_nama_jenis' => 'nama_dan_jenis_kebudayaan',
                        'dimana_desa' => 'desa_lokasi',
                        'dimana_lokasi_detail' => 'detail_lokasi',
                        'kapan_pelaksanaan' => 'tanggal_pelaksanaan',
                    ];

                    foreach ($data as $key => $value) {
                        $newKey = $mappings[$key] ?? $key;
                        $newData[$newKey] = $value;
                    }

                    DB::table('cultural_submissions')
                        ->where('id', $submission->id)
                        ->update(['category_data' => json_encode($newData)]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed.
    }
};
