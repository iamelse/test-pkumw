<?php

namespace App\Http\Requests\API\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // RM number biasanya tetap wajib supaya data unik
            'rm_number'      => 'required|string|max:50',

            // Untuk update, biasanya first_name & last_name tetap wajib
            'first_name'     => 'required|string|max:50',
            'last_name'      => 'required|string|max:50',
            'gender'         => 'required|string',
            'married_status' => 'required|string',

            // Optional fields (boleh diisi sebagian)
            'avatar'                => 'nullable|string',
            'birth_place'           => 'nullable|string|max:100',
            'birth_date'            => 'nullable|date',
            'phone_number'          => 'nullable|string|max:20',
            'street_address'        => 'nullable|string|max:255',
            'city_address'          => 'nullable|string|max:100',
            'state_address'         => 'nullable|string|max:100',
            'emergency_full_name'   => 'nullable|string|max:100',
            'emergency_phone_number'=> 'nullable|string|max:20',
            'identity_number'       => 'nullable|string|max:30',
            'bpjs_number'           => 'nullable|string|max:30',
            'ethnic'                => 'nullable|string|max:50',
            'education'             => 'nullable|string|max:50',
            'communication_barrier' => 'nullable|string',
            'disability_status'     => 'nullable|string|max:100',
            'father_name'           => 'nullable|string|max:100',
            'mother_name'           => 'nullable|string|max:100',
            'job'                   => 'nullable|string|max:50',
            'blood_type'            => 'nullable|string|max:3',
        ];
    }
}