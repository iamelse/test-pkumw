@extends('layouts.app')

@section('content')
<div x-data="patientPage()" class="p-4 mx-auto w-full md:p-6 space-y-10">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Patients</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage patient records, search, and filter easily.</p>
        </div>
        <div class="mt-3 sm:mt-0">
            <a href="{{ route('be.patient.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                <i class='bx bx-plus mr-2 text-lg'></i>
                New Patient
            </a>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Table Header --}}
        <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
            {{-- Search Form --}}
            <form method="GET" action="{{ route('be.patient.index') }}" class="flex-1">
                <input type="hidden" name="blood_type" value="{{ request('blood_type') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <div class="relative max-w-md">
                    <span class="absolute top-1/2 left-4 -translate-y-1/2 pointer-events-none">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by RM number or name..." class="dark:bg-dark-900 shadow-theme-xs focus:border-blue-600 focus:ring-blue-600/10 dark:focus:border-blue-600 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>
            </form>

            {{-- Filter & Reset --}}
            <div class="flex flex-row gap-3 mt-3 sm:mt-0">
                <button @click="openModal('filter')" class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">Filter</button>
                <a href="{{ route('be.patient.index') }}" class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">Reset Filter</a>
            </div>
        </div>

        {{-- Table --}}
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead class="border-y border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                    <tr>
                        @foreach(['No', 'RM Number','Name', 'Blood Type', 'Gender','Birth Of Date','Address','Action'] as $header)
                            <th class="px-6 py-3 whitespace-nowrap text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">{{ $header }}</p>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($patientsDTO as $patient)
                        <tr>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->rm_number }}</td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center aspect-square w-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ $patient->avatar() }}" 
                                            alt="{{ $patient->fullName() }}" 
                                            class="object-cover w-full h-full">
                                    </div>
                                    <div>
                                        <span class="block font-medium">{{ $patient->fullName() }}</span>
                                        <span class="text-gray-500 text-sm dark:text-gray-400">{{ $patient->phone_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->bloodType() }}</td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">
                                @php $gender = $patient->genderBadge(); @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $gender['class'] }}">{{ $gender['label'] }}</span>
                            </td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->birthInfo() }}</td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->address() }}</td>
                            <td class="px-6 py-3 text-center flex justify-center gap-2">
                                <!-- Detail / View -->
                                <button 
                                    @click="showPatientModal({{ $patient->id }})"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white shadow-theme-xs text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                    title="View"
                                    :disabled="loadingId === {{ $patient->id }} && loadingAction === 'view'"
                                >
                                    <template x-if="!(loadingId === {{ $patient->id }} && loadingAction === 'view')">
                                        <i class='bx bx-show text-lg'></i>
                                    </template>
                                    <template x-if="loadingId === {{ $patient->id }} && loadingAction === 'view'">
                                        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z"></path>
                                        </svg>
                                    </template>
                                </button>

                                {{-- Edit Button Direct Link --}}
                                <a href="{{ route('be.patient.edit', $patient->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white shadow-theme-xs text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200" title="Edit">
                                    <i class='bx bx-pencil text-lg'></i>
                                </a>

                                <!-- Delete -->
                                <button
                                    @click="openDeleteModal({{ $patient->id }}, '{{ $patient->fullName() }}')"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white shadow-theme-xs text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                    title="Delete"
                                >
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No patients found.</td></tr>
                    @endforelse
                </tbody>
            </table>

            @include('pages.backend.patient.partials.pagination')

        </div>
    </div>

    @include('pages.backend.patient.partials.filter-modal')

    {{-- Patient Modal (View Only) --}}
    <div x-show="modals.patient" x-transition.opacity class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-[99999]">
        <!-- Overlay -->
        <div @click="closeModal('patient')" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

        <!-- Modal Box -->
        <div @click.outside="closeModal('patient')" x-transition 
            class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white pt-5 pb-6 px-5 dark:bg-gray-900">

            <!-- Close Button -->
            <button @click="closeModal('patient')" 
                class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6L18 18M6 18L18 6" />
                </svg>
            </button>

            <!-- Header -->
            <div class="mb-5 flex items-center gap-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                    <img :src="patient.avatar || 'https://api.dicebear.com/6.x/identicon/svg?seed=default'" 
                        alt="Avatar" class="object-cover w-full h-full">
                </div>
                <div>
                    <h4 class="text-2xl font-semibold text-gray-800 dark:text-white" 
                        x-text="(patient.first_name || '') + ' ' + (patient.last_name || '')"></h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Patient information overview</p>
                </div>
            </div>

            <!-- Patient Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="field in [
                    'rm_number','identity_number','bpjs_number',
                    'first_name','last_name','gender',
                    'birth_place','birth_date','phone_number',
                    'street_address','city_address','state_address',
                    'emergency_full_name','emergency_phone_number',
                    'ethnic','education','married_status','job',
                    'father_name','mother_name','blood_type',
                    'communication_barrier','disability_status'
                ]" :key="field">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                            x-text="formatLabel(field)"></label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                            x-text="patient[field] ?? '-'"></p>
                    </div>
                </template>
            </div>

        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="modals.delete" x-transition.opacity class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-[99999]">
        <div @click="closeModal('delete')" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
        <div @click.outside="closeModal('delete')" x-transition class="relative w-full max-w-md rounded-3xl bg-white p-6 dark:bg-gray-900">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Confirm Deletion</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Are you sure you want to delete <span class="font-medium" x-text="deletePatientName"></span>?
            </p>
            <div class="mt-4 flex justify-end gap-3">
                <button @click="closeModal('delete')" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">Cancel</button>

                {{-- Form Submit --}}
                <form :action="'{{ route('be.patient.destroy', ':id') }}'.replace(':id', deletePatientId)" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function patientPage() {
    return {
        patient: {},
        mode: 'view', // 'view', 'edit', 'create'
        modals: { filter: false, patient: false, delete: false },
        loadingId: null,
        loadingAction: null,

        deletePatientId: null,
        deletePatientName: '',

        formatLabel(field) {
            const custom = {
                rm_number: 'RM Number',
                bpjs_number: 'BPJS Number',
                identity_number: 'Identity Number',
            };
            if (custom[field]) return custom[field];

            // fallback → Capitalize biasa
            return field
                .replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());
        },

        openModal(name, mode = 'view', data = {}) {
            this.mode = mode;
            this.modals[name] = true;
            if (mode === 'create') this.resetPatient();
            else this.patient = data;
        },

        closeModal(name) {
            this.modals[name] = false;
            if (name === 'delete') {
                this.deletePatientId = null;
                this.deletePatientName = '';
            }
        },

        resetPatient() {
            this.patient = {
                rm_number: '',
                identity_number: '',
                bpjs_number: '',
                first_name: '',
                last_name: '',
                gender: '',
                birth_place: '',
                birth_date: '',
                phone_number: '',
                street_address: '',
                city_address: '',
                state_address: '',
                emergency_full_name: '',
                emergency_phone_number: '',
                ethnic: '',
                education: '',
                married_status: '',
                job: '',
                father_name: '',
                mother_name: '',
                blood_type: '',
                communication_barrier: '',
                disability_status: ''
            };
        },

        showPatientModal(id) {
            this.loadingId = id;
            this.loadingAction = 'view';
            axios.get('{{ route('be.patient.show', ':id') }}'.replace(':id', id))
                .then(res => {
                    setTimeout(() => {
                        this.patient = res.data.data;
                        this.mode = 'view';
                        this.modals.patient = true;
                        this.loadingId = null;
                        this.loadingAction = null;
                    }, 300);
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to load patient details');
                    this.loadingId = null;
                    this.loadingAction = null;
                });
        },

        openDeleteModal(id, name) {
            this.deletePatientId = id;
            this.deletePatientName = name;
            this.modals.delete = true;
        },
    }
}
</script>
@endsection