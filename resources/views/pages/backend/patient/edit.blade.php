@extends('layouts.app')

@section('content')
<div class="p-4 mx-auto w-full md:p-6 space-y-10">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Patient</h1>
            <p class="text-gray-600 dark:text-gray-400">Update patient details below.</p>
        </div>
        <div class="mt-3 sm:mt-0">
            <a href="{{ route('be.patient.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300">
                <i class='bx bx-arrow-back mr-2 text-lg'></i>Back to List
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03] px-6 pb-6">

        {{-- Patient Avatar --}}
        <div class="flex justify-center m-4">
            <div class="w-36 h-36 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                <img src="{{ old('avatar', $patient->avatar ?? 'https://api.dicebear.com/6.x/identicon/svg?seed=default') }}" 
                    alt="Avatar" class="object-cover w-full h-full">
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('be.patient.update', $patient->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- 1. Patient Identity --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <h3 class="col-span-2 text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Patient Identity</h3>

                @php
                    $identityFields = [
                        ['label'=>'RM Number','name'=>'rm_number','placeholder'=>'Enter RM Number'],
                        ['label'=>'Identity Number','name'=>'identity_number','placeholder'=>'Enter Identity Number'],
                        ['label'=>'BPJS Number','name'=>'bpjs_number','placeholder'=>'Enter BPJS Number'],

                        [
                            'label'       => 'Gender',
                            'name'        => 'gender',
                            'type'        => 'select',
                            'options'     => [
                                ['key' => 'male',   'value' => 'Male'],
                                ['key' => 'female', 'value' => 'Female'],
                            ],
                            'placeholder' => 'Select Gender',
                        ],

                        ['label'=>'First Name','name'=>'first_name','placeholder'=>'Enter First Name'],
                        ['label'=>'Last Name','name'=>'last_name','placeholder'=>'Enter Last Name'],
                        ['label'=>'Birth Place','name'=>'birth_place','placeholder'=>'Enter Birth Place'],
                        ['label'=>'Birth Date','name'=>'birth_date','type'=>'date','placeholder'=>'Enter Birth Date'],

                        [
                            'label'       => 'Blood Type',
                            'name'        => 'blood_type',
                            'type'        => 'select',
                            'options'     => [
                                ['key' => 'A',  'value' => 'A'],
                                ['key' => 'B',  'value' => 'B'],
                                ['key' => 'AB', 'value' => 'AB'],
                                ['key' => 'O',  'value' => 'O'],
                            ],
                            'placeholder' => 'Select Blood Type',
                        ],

                        [
                            'label'       => 'Ethnic',
                            'name'        => 'ethnic',
                            'type'        => 'select',
                            'options'     => [
                                ['key' => 'Jawa',    'value' => 'Jawa'],
                                ['key' => 'Sunda',   'value' => 'Sunda'],
                                ['key' => 'Batak',   'value' => 'Batak'],
                                ['key' => 'Minang',  'value' => 'Minang'],
                                ['key' => 'Bugis',   'value' => 'Bugis'],
                                ['key' => 'Papua',   'value' => 'Papua'],
                                ['key' => 'Lainnya', 'value' => 'Lainnya'],
                            ],
                            'placeholder' => 'Select Ethnic',
                        ],

                        [
                            'label'       => 'Education',
                            'name'        => 'education',
                            'type'        => 'select',
                            'options'     => [
                                ['key' => 'SD', 'value' => 'SD'],
                                ['key' => 'SMP','value' => 'SMP'],
                                ['key' => 'SMA','value' => 'SMA'],
                                ['key' => 'D1', 'value' => 'D1'],
                                ['key' => 'D2', 'value' => 'D2'],
                                ['key' => 'D3', 'value' => 'D3'],
                                ['key' => 'D4', 'value' => 'D4'],
                                ['key' => 'S1', 'value' => 'S1'],
                                ['key' => 'S2', 'value' => 'S2'],
                                ['key' => 'S3', 'value' => 'S3'],
                                ['key' => 'Pendidikan Profesi', 'value' => 'Pendidikan Profesi'],
                            ],
                            'placeholder' => 'Select Education',
                        ],

                        [
                            'label'       => 'Married Status',
                            'name'        => 'married_status',
                            'type'        => 'select',
                            'options'     => [
                                ['key' => 'Belum Kawin', 'value' => 'Belum Kawin'],
                                ['key' => 'Kawin',       'value' => 'Kawin'],
                                ['key' => 'Cerai Hidup', 'value' => 'Cerai Hidup'],
                                ['key' => 'Cerai Mati',  'value' => 'Cerai Mati'],
                            ],
                            'placeholder' => 'Select Married Status',
                        ],

                        [
                            'label'       => 'Job',
                            'name'        => 'job',
                            'type'        => 'select',
                            'options'     => [
                                ['key'=>'Pelajar','value'=>'Pelajar'],
                                ['key'=>'Mahasiswa','value'=>'Mahasiswa'],
                                ['key'=>'Pegawai Negeri','value'=>'Pegawai Negeri'],
                                ['key'=>'Pegawai Swasta','value'=>'Pegawai Swasta'],
                                ['key'=>'Wiraswasta','value'=>'Wiraswasta'],
                                ['key'=>'Petani','value'=>'Petani'],
                                ['key'=>'Nelayan','value'=>'Nelayan'],
                                ['key'=>'Buruh','value'=>'Buruh'],
                                ['key'=>'Ibu Rumah Tangga','value'=>'Ibu Rumah Tangga'],
                                ['key'=>'Tidak Bekerja','value'=>'Tidak Bekerja'],
                                ['key'=>'Pensiunan','value'=>'Pensiunan'],
                                ['key'=>'Lainnya','value'=>'Lainnya'],
                            ],
                            'placeholder' => 'Select Job',
                        ],
                    ];
                @endphp

                @foreach($identityFields as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ $field['label'] }}</label>

                        @switch($field['type'] ?? 'text')
                            @case('select')
                                <select name="{{ $field['name'] }}" 
                                    class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                                        focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600
                                        @error($field['name']) border-red-500 focus:border-blue-600 focus:ring-blue-600 @enderror">
                                    <option value="">{{ $field['placeholder'] }}</option>
                                    @foreach($field['options'] as $option)
                                        <option value="{{ $option['key'] }}" 
                                            {{ old($field['name'], $patient->{$field['name']}) === $option['key'] ? 'selected' : '' }}>
                                            {{ $option['value'] ?? $option['key'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @break

                            @case('date')
                                <input type="date" name="{{ $field['name'] }}" 
                                    value="{{ old($field['name'], $patient->{$field['name']}) }}" 
                                    placeholder="{{ $field['placeholder'] }}"
                                    class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                @break

                            @default
                                <input type="text" name="{{ $field['name'] }}" 
                                    value="{{ old($field['name'], $patient->{$field['name']}) }}" 
                                    placeholder="{{ $field['placeholder'] }}"
                                    class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @endswitch

                        @error($field['name'])
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            {{-- Contact & Address --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <h3 class="col-span-2 text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Contact & Address</h3>

                @php
                    $contactFields = [
                        ['label'=>'Phone Number','name'=>'phone_number','placeholder'=>'Enter Phone Number'],
                        ['label'=>'Street Address','name'=>'street_address','placeholder'=>'Enter Street Address'],
                        ['label'=>'City Address','name'=>'city_address','placeholder'=>'Enter City'],
                        ['label'=>'State Address','name'=>'state_address','placeholder'=>'Enter State'],
                        ['label'=>'Emergency Contact Name','name'=>'emergency_full_name','placeholder'=>'Enter Emergency Contact Name'],
                        ['label'=>'Emergency Contact Phone','name'=>'emergency_phone_number','placeholder'=>'Enter Emergency Contact Phone']
                    ];
                @endphp

                @foreach($contactFields as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">{{ $field['label'] }}</label>
                        <input type="text" name="{{ $field['name'] }}" 
                            value="{{ old($field['name'], $patient->{$field['name']}) }}" 
                            placeholder="{{ $field['placeholder'] }}"
                            class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        @error($field['name'])
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            {{-- Additional Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <h3 class="col-span-2 text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Additional Information</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Communication Barrier</label>
                    <textarea name="communication_barrier" class="mt-1 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('communication_barrier', $patient->communication_barrier) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Disability Status</label>
                    <input type="text" name="disability_status" 
                        value="{{ old('disability_status', $patient->disability_status) }}" 
                        placeholder="Enter Disability Status"
                        class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Father's Name</label>
                    <input type="text" name="father_name" 
                        value="{{ old('father_name', $patient->father_name) }}" 
                        placeholder="Enter Father's Name"
                        class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Mother's Name</label>
                    <input type="text" name="mother_name" 
                        value="{{ old('mother_name', $patient->mother_name) }}" 
                        placeholder="Enter Mother's Name"
                        class="mt-1 h-10 w-full rounded-lg border px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Update Patient
                </button>
            </div>
        </form>
    </div>
</div>
@endsection