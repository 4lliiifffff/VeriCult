<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActiveCultureReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('pengusul') || $this->user()->hasRole('pengusul-desa');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Kategori OPK mapping
            'kategori_opk' => 'required|string|in:Tradisi Lisan,Manuskrip,Adat Istiadat,Ritus,Pengetahuan Tradisional,Teknologi Tradisional,Seni,Bahasa,Permainan Rakyat,Olahraga Tradisional,Cagar Budaya',

            // 5W+1H Questions - WHAT
            'w1_apa_nama_kebudayaan' => 'required|string|max:255',
            'w1_apa_jenis' => 'required|string|max:255',
            'w1_apa_penjelasan' => 'required|string|max:2000',

            // WHERE
            'w2_dimana_lokasi' => 'required|string|max:500',
            'w2_dimana_koordinat_lat' => 'nullable|numeric|between:-90,90',
            'w2_dimana_koordinat_lng' => 'nullable|numeric|between:-180,180',

            // WHEN
            'w3_kapan_tanggal' => 'required|date_format:Y-m-d',
            'w3_kapan_frekuensi' => 'required|string|in:Setiap Hari,Setiap Minggu,Setiap Bulan,Musiman/Berkala,Sesekali/Acara Tertentu',

            // WHO
            'w4_siapa_pelaku' => 'required|string|max:500',
            'w4_siapa_kontribusi' => 'required|string|max:2000',

            // WHY
            'w5_mengapa_tujuan' => 'required|string|max:2000',
            'w5_mengapa_makna_budaya' => 'required|string|max:2000',

            // HOW
            'w6_bagaimana_proses' => 'required|string|max:2000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'kategori_opk' => 'Kategori Unit Kebudayaan',
            'w1_apa_nama_kebudayaan' => 'Nama Kebudayaan',
            'w1_apa_jenis' => 'Jenis Kebudayaan',
            'w1_apa_penjelasan' => 'Penjelasan Kebudayaan',
            'w2_dimana_lokasi' => 'Lokasi Pelaksanaan',
            'w2_dimana_koordinat_lat' => 'Latitude',
            'w2_dimana_koordinat_lng' => 'Longitude',
            'w3_kapan_tanggal' => 'Tanggal Pelaksanaan',
            'w3_kapan_frekuensi' => 'Frekuensi Pelaksanaan',
            'w4_siapa_pelaku' => 'Pelaku Kebudayaan',
            'w4_siapa_kontribusi' => 'Kontribusi Pihak-Pihak',
            'w5_mengapa_tujuan' => 'Tujuan Pelaksanaan',
            'w5_mengapa_makna_budaya' => 'Makna Budaya',
            'w6_bagaimana_proses' => 'Proses Pelaksanaan',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            '*.required' => ':attribute wajib diisi.',
            '*.string' => ':attribute harus berupa teks.',
            '*.max' => ':attribute tidak boleh lebih dari :max karakter.',
            '*.numeric' => ':attribute harus berupa angka.',
            '*.date_format' => ':attribute harus format: YYYY-MM-DD.',
            '*.in' => ':attribute tidak valid. Pilih dari opsi yang tersedia.',
            '*.between' => ':attribute harus berada di antara :min dan :max.',
        ];
    }
}
