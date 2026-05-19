<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniquePhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tables = [
            'pengusul_profiles',
            'pengusul_desa_profiles',
            'validator_profiles',
            'admin_profiles',
            'super_admin_profiles',
        ];

        foreach ($tables as $table) {
            // Check if the table actually has a no_hp column before querying
            if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'no_hp')) {
                $exists = DB::table($table)->where('no_hp', $value)->exists();
                if ($exists) {
                    $fail('Nomor telepon ini sudah digunakan oleh akun lain.');
                    return;
                }
            }
        }
    }
}
