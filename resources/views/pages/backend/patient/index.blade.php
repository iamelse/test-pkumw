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
                                        <div class="animate-spin stroke-blue-600 text-gray-200 dark:text-gray-800">
                                            <svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="14" cy="14" r="12" stroke="currentColor" stroke-width="4"></circle>
                                                <mask id="path-2-inside-1_3755_26205" fill="white">
                                                    <path d="M26.0032 14C27.106 14 28.0146 13.1015 27.8578 12.0099C27.5269 9.70542 26.6246 7.5087 25.2196 5.62615C23.4144 3.20752 20.876 1.43698 17.9827 0.578433C15.0893 -0.280117 11.996 -0.18071 9.16381 0.861838C6.95934 1.67331 5.00491 3.02235 3.47057 4.77332C2.74376 5.60275 3.01525 6.85142 3.93957 7.45295C4.86389 8.05447 6.08878 7.77457 6.86161 6.98784C7.89234 5.93857 9.14776 5.12338 10.5434 4.60965C12.5677 3.8645 14.7786 3.79345 16.8466 4.40709C18.9145 5.02073 20.7288 6.2862 22.0191 8.01488C22.9086 9.20671 23.5162 10.5747 23.8078 12.0164C24.0264 13.0973 24.9004 14 26.0032 14Z"></path>
                                                </mask>
                                                <path d="M26.0032 14C27.106 14 28.0146 13.1015 27.8578 12.0099C27.5269 9.70542 26.6246 7.5087 25.2196 5.62615C23.4144 3.20752 20.876 1.43698 17.9827 0.578433C15.0893 -0.280117 11.996 -0.18071 9.16381 0.861838C6.95934 1.67331 5.00491 3.02235 3.47057 4.77332C2.74376 5.60275 3.01525 6.85142 3.93957 7.45295C4.86389 8.05447 6.08878 7.77457 6.86161 6.98784C7.89234 5.93857 9.14776 5.12338 10.5434 4.60965C12.5677 3.8645 14.7786 3.79345 16.8466 4.40709C18.9145 5.02073 20.7288 6.2862 22.0191 8.01488C22.9086 9.20671 23.5162 10.5747 23.8078 12.0164C24.0264 13.0973 24.9004 14 26.0032 14Z" stroke="currentStroke" stroke-width="8" mask="url(#path-2-inside-1_3755_26205)"></path>
                                            </svg>
                                        </div>
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
    @include('pages.backend.patient.partials.show-modal')

    {{-- Delete Confirmation Modal --}}
    @include('pages.backend.patient.partials.delete-confirmation-modal')

</div>

<script>
    window.routes = {
        patientShow: "{{ route('be.patient.show', ':id') }}",
    }
</script>
@endsection