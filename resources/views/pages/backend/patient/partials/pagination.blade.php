@if(!empty($patients['data']) && $patients['data']['total'] > 0)
    @php
        $patientsData = $patients['data'];
        $currentPage = ceil($patientsData['from'] / $patientsData['per_page']);
        $lastPage = $patientsData['last_page'] ?? 1;
        $queryParams = array_filter($filters ?? []);
        $startPage = max($currentPage - 2, 1);
        $endPage = min($currentPage + 2, $lastPage);
    @endphp

    <div class="border-t border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between gap-2 px-6 py-4">

            {{-- Showing info --}}
            <div class="text-sm text-gray-700 dark:text-gray-400">
                Showing {{ $patientsData['from'] }} to {{ $patientsData['to'] }} of {{ $patientsData['total'] }} patients
            </div>

            {{-- Pagination controls --}}
            <div class="flex items-center gap-2">

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
                            <a href="{{ route('be.patient.index', array_merge($queryParams, ['page' => 1])) }}" 
                               class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white">
                                1
                            </a>
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
                            <a href="{{ route('be.patient.index', array_merge($queryParams, ['page' => $lastPage])) }}" 
                               class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white">
                                {{ $lastPage }}
                            </a>
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
@endif