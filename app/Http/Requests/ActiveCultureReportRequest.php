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
            'category' => 'required|string',
            'category_data' => 'required|array',
            'category_data.kategori_opk' => 'required|string',
            'category_data.nama_dan_jenis_kebudayaan' => 'required|string|max:255',
            'category_data.desa_lokasi' => 'required|string|max:255',
            'category_data.detail_lokasi' => 'required|string|max:255',
            'category_data.tanggal_pelaksanaan' => 'required|date',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,webm|max:20480', // 20MB max
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'category_data.kategori_opk' => 'Kategori Unit Kebudayaan',
            'category_data.nama_dan_jenis_kebudayaan' => 'Nama dan Jenis Kebudayaan',
            'category_data.desa_lokasi' => 'Nama Desa / Kelurahan',
            'category_data.detail_lokasi' => 'Detail Lokasi Pelaksanaan',
            'category_data.tanggal_pelaksanaan' => 'Tanggal Pelaksanaan',
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
