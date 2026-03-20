<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\CulturalSubmission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('cultural_submissions')->chunkById(100, function ($submissions) {
            foreach ($submissions as $submission) {
                if (empty($submission->category_data)) {
                    continue;
                }

                $oldData = json_decode($submission->category_data, true);
                if (!is_array($oldData)) {
                    continue;
                }

                $newData = [];
                foreach ($oldData as $key => $value) {
                    $newKey = $this->transformKey($key);
                    $newData[$newKey] = $value;
                }

                DB::table('cultural_submissions')
                    ->where('id', $submission->id)
                    ->update(['category_data' => json_encode($newData)]);
            }
        });
    }

    private function transformKey(string $key): string
    {
        // Special mappings for fields that changed names more significantly
        $specialMap = [
            'aktif_nama_dan_jenis_kebudayaan' => 'nama_dan_jenis_kebudayaan',
            'aktif_desa_dimana' => 'desa_lokasi',
            'aktif_detail_lokasi_dimana' => 'detail_lokasi',
            'aktif_kapan_pelaksanaannya' => 'tanggal_pelaksanaan',
            'b4_jumlah_min' => 'jumlah_pemain_minimal',
            'b5_jumlah_max' => 'jumlah_pemain_maksimal',
            'b6_orang_pengguna' => 'kriteria_pengguna',
            'b6_waktu_penggunaan' => 'kriteria_waktu',
            'b6_tempat_penggunaan' => 'kriteria_tempat',
        ];

        if (isset($specialMap[$key])) {
            return $specialMap[$key];
        }

        // Remove b1_, w1_, etc prefixes (e.g., b1_nama_objek -> nama_objek)
        return preg_replace('/^[bw]\d+_/', '', $key);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Downgrade is not easily reversible without category-specific knowledge of prefixes.
    }
};
