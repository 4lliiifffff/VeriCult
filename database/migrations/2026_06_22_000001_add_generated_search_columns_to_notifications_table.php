<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambahkan generated columns (STORED) ke tabel notifications agar
 * query pencarian LIKE pada field JSON 'title' dan 'message' dapat
 * menggunakan index, menggantikan full table scan sebelumnya.
 *
 * Generated columns ini secara otomatis diperbarui oleh MySQL
 * setiap kali baris di-INSERT atau di-UPDATE — tanpa biaya runtime.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Gunakan raw SQL karena Blueprint Laravel belum support
        // storedAs() + ekspresi JSON_UNQUOTE secara native di semua versi.
        DB::statement("
            ALTER TABLE notifications
            ADD COLUMN notif_title VARCHAR(255)
                GENERATED ALWAYS AS (
                    LOWER(JSON_UNQUOTE(JSON_EXTRACT(data, '$.title')))
                ) STORED NULL,
            ADD COLUMN notif_message TEXT
                GENERATED ALWAYS AS (
                    LOWER(JSON_UNQUOTE(JSON_EXTRACT(data, '$.message')))
                ) STORED NULL
        ");

        // Index pada notif_title (full)
        DB::statement("
            ALTER TABLE notifications
            ADD INDEX idx_notif_title (notif_title)
        ");

        // Index prefix 100 karakter pada notif_message (TEXT tidak bisa full-index)
        DB::statement("
            ALTER TABLE notifications
            ADD INDEX idx_notif_message (notif_message(100))
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifications DROP INDEX idx_notif_message");
        DB::statement("ALTER TABLE notifications DROP INDEX idx_notif_title");
        DB::statement("ALTER TABLE notifications DROP COLUMN notif_message");
        DB::statement("ALTER TABLE notifications DROP COLUMN notif_title");
    }
};
