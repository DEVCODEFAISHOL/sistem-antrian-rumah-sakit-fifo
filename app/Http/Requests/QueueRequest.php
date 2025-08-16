<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
}
