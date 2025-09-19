<div x-show="modals.filter" x-transition.opacity class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-[99999]">
    
    {{-- Backdrop --}}
    <div @click="closeModal('filter')" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[6px]"></div>
    
    {{-- Modal Content --}}
    <div @click.outside="closeModal('filter')" 
         x-transition 
         class="no-scrollbar relative w-full max-w-[600px] overflow-y-auto rounded-3xl bg-white p-6 dark:bg-gray-900">
        
        {{-- Close Button --}}
        <button @click="closeModal('filter')" 
                class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300">
            <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6L18 18M6 18L18 6" />
            </svg>
        </button>

        {{-- Modal Header --}}
        <div class="mb-5">
            <h4 class="text-2xl font-semibold text-gray-800 dark:text-white">Filter Patients</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Filter the patient list by criteria below.
            </p>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('be.patient.index') }}" class="flex flex-col gap-5">
            <input type="hidden" name="search" value="{{ request('search') }}">

            {{-- Gender --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Gender</label>
                <select name="gender" 
                        class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">All</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            {{-- Blood Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">Blood Type</label>
                <select name="blood_type" 
                        class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                    <option value="">All</option>
                    <option value="A" {{ request('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ request('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ request('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ request('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                </select>
            </div>

            {{-- Modal Footer --}}
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" 
                        @click="closeModal('filter')" 
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>
</div>