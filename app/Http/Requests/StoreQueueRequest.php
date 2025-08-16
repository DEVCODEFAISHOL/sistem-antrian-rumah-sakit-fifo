<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PoliQuota;
use Carbon\Carbon;

class StoreQueueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh middleware 'role:staff' pada file web.php
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id'        => 'required|exists:patients,id',
            'poli_id'           => 'required|exists:polis,id',
            'dokter_id'         => 'nullable|exists:dokters,id',
            'complaint'         => 'required|string|min:5',
            'checkup_date'      => 'required|date|after_or_equal:today',
            'jenis_kunjungan'   => 'required|in:baru,lama',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $poliId = $this->input('poli_id');
            $checkupDate = $this->input('checkup_date');

            if ($poliId && $checkupDate) {
                // Cari atau buat kuota untuk poli dan tanggal yang dipilih
                $quota = PoliQuota::firstOrCreate(
                    [
                        'poli_id' => $poliId,
                        'quota_date' => Carbon::parse($checkupDate)->format('Y-m-d'),
                    ],
                    [
                        'max_quota' => 20, // Nilai default jika record baru dibuat
                        'current_count' => 0
                    ]
                );

                // Cek apakah kuota sudah penuh
                if ($quota->current_count >= $quota->max_quota) {
                    $validator->errors()->add(
                        'poli_id',
                        'Kuota untuk poli ini pada tanggal yang dipilih sudah penuh. Silakan pilih tanggal lain.'
                    );
                }
            }
        });
    }
}
