@extends('layouts.app')

@section('content')
<div class="p-4 mx-auto w-full md:p-6 space-y-10">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Patients
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Manage patient records, search, and filter easily.
            </p>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
        {{-- Table Header Section --}}
        <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">

            {{-- Search Form di kiri --}}
            <form method="GET" action="{{ route('be.patient.index') }}" class="flex-1">
                <div class="relative max-w-md">
                    <span class="absolute top-1/2 left-4 -translate-y-1/2 pointer-events-none">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by RM number or name..."
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-blue-600 focus:ring-blue-600/10 dark:focus:border-blue-600 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>
            </form>

            {{-- Filter & Reset Filter di kanan --}}
            <div class="flex flex-row gap-3 mt-3 sm:mt-0">

                {{-- Filter Button --}}
                <button
                    class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                >
                    <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M2.29 5.904H17.707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17.708 14.096H2.291" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.083 3.333c1.42 0 2.57 1.151 2.57 2.571s-1.15 2.571-2.57 2.571-2.571-1.151-2.571-2.571 1.151-2.571 2.571-2.571Z" stroke-width="1.5" />
                        <path d="M7.917 11.525c-1.42 0-2.571 1.151-2.571 2.571s1.151 2.571 2.571 2.571 2.571-1.151 2.571-2.571-1.151-2.571-2.571-2.571Z" stroke-width="1.5" />
                    </svg>
                    Filter
                </button>

                {{-- Reset Filter Button --}}
                <a href="{{ route('be.patient.index') }}"
                class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    Reset Filter
                </a>
            </div>

        </div>

        {{-- Table Section --}}
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead class="border-y border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                    <tr>
                        @foreach(['No', 'RM Number','Name','Gender','Birth Of Date','Address','Action'] as $header)
                            <th class="px-6 py-3 whitespace-nowrap text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                    {{ $header }}
                                </p>
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
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ $patient->avatar() }}" alt="{{ $patient->fullName() }}" class="object-cover w-full h-full">
                                    </div>
                                    <div>
                                        <span class="block font-medium">{{ $patient->fullName() }}</span>
                                        <span class="text-gray-500 text-sm dark:text-gray-400">{{ $patient->phone_number }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">
                                @php $gender = $patient->genderBadge(); @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $gender['class'] }}">
                                    {{ $gender['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->birthInfo() }}</td>
                            <td class="px-6 py-3 text-gray-800 dark:text-gray-200">{{ $patient->address() }}</td>
                            <td class="px-6 py-3 text-center">
                                {{-- Delete icon --}}
                                <button class="hover:text-red-500"></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between gap-2 px-6 py-4">

                    {{-- Showing info --}}
                    <div class="text-sm text-gray-700 dark:text-gray-400">
                        Showing {{ $patients['data']['from'] }} to {{ $patients['data']['to'] }} of {{ $patients['data']['total'] }} patients
                    </div>

                    {{-- Pagination controls --}}
                    <div class="flex items-center gap-2">

                        @php
                            $currentPage = ceil($patients['data']['from'] / $patients['data']['per_page']);
                            $lastPage = $patients['data']['last_page'];
                            $queryParams = array_filter($filters); // hapus null/empty
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($currentPage + 2, $lastPage);
                        @endphp

                        {{-- Previous --}}
                        <a href="{{ $currentPage > 1 ? route('be.patient.index', array_merge($queryParams, ['page' => $currentPage - 1])) : '#' }}"
                        class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:px-3.5 sm:py-2.5
                        {{ $currentPage > 1 ? '' : 'pointer-events-none opacity-50' }}">
                            <span class="inline sm:hidden">
                                {{-- Left Arrow SVG --}}
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.58203 9.99868C2.58174 10.1909 2.6549 10.3833 2.80152 10.53L7.79818 15.5301C8.09097 15.8231 8.56584 15.8233 8.85883 15.5305C9.15183 15.2377 9.152 14.7629 8.85921 14.4699L5.13911 10.7472L16.6665 10.7472C17.0807 10.7472 17.4165 10.4114 17.4165 9.99715C17.4165 9.58294 17.0807 9.24715 16.6665 9.24715L5.14456 9.24715L8.85919 5.53016C9.15199 5.23717 9.15184 4.7623 8.85885 4.4695C8.56587 4.1767 8.09099 4.17685 7.79819 4.46984L2.84069 9.43049C2.68224 9.568 2.58203 9.77087 2.58203 9.99715Z"/>
                                </svg>
                            </span>
                            <span class="hidden sm:inline">Previous</span>
                        </a>

                        {{-- Page Numbers --}}
                        <ul class="hidden items-center gap-0.5 sm:flex">
                            {{-- First Page --}}
                            @if($startPage > 1)
                                <li>
                                    <a href="{{ route('be.patient.index', array_merge($queryParams, ['page' => 1])) }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white">1</a>
                                </li>
                                @if($startPage > 2)
                                    <li>
                                        <span class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 dark:text-gray-400">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Pages around current --}}
                            @for($i = $startPage; $i <= $endPage; $i++)
                                <li>
                                    <a href="{{ route('be.patient.index', array_merge($queryParams, ['page' => $i])) }}"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium {{ $i == $currentPage ? 'bg-blue-600 text-white hover:bg-blue-600 hover:text-white' : 'text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            {{-- Last Page --}}
                            @if($endPage < $lastPage)
                                @if($endPage < $lastPage - 1)
                                    <li>
                                        <span class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 dark:text-gray-400">...</span>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('be.patient.index', array_merge($queryParams, ['page' => $lastPage])) }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white">{{ $lastPage }}</a>
                                </li>
                            @endif
                        </ul>

                        {{-- Next --}}
                        <a href="{{ $currentPage < $lastPage ? route('be.patient.index', array_merge($queryParams, ['page' => $currentPage + 1])) : '#' }}"
                        class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:px-3.5 sm:py-2.5
                        {{ $currentPage < $lastPage ? '' : 'pointer-events-none opacity-50' }}">
                            <span class="hidden sm:inline">Next</span>
                            <span class="inline sm:hidden">
                                {{-- Right Arrow SVG --}}
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4165 9.9986C17.4168 10.1909 17.3437 10.3832 17.197 10.53L12.2004 15.5301C11.9076 15.8231 11.4327 15.8233 11.1397 15.5305C10.8467 15.2377 10.8465 14.7629 11.1393 14.4699L14.8594 10.7472L3.33203 10.7472C2.91782 10.7472 2.58203 10.4114 2.58203 9.99715C2.58203 9.58294 2.91782 9.24715 3.33203 9.24715L14.854 9.24715L11.1393 5.53016C10.8465 5.23717 10.8467 4.7623 11.1397 4.4695C11.4327 4.1767 11.9075 4.17685 12.2003 4.46984L17.1578 9.43049C17.3163 9.568 17.4165 9.77087 17.4165 9.99715Z"/>
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection