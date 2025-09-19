<div x-show="modals.patient" x-transition.opacity 
    class="fixed inset-0 flex items-center justify-center p-5 z-[99999]">

    <!-- Overlay -->
    <div @click="closeModal('patient')" 
        class="fixed inset-0 bg-gray-400/50 backdrop-blur-[6px]"></div>

    <!-- Modal Box -->
    <div @click.outside="closeModal('patient')" x-transition
        class="no-scrollbar relative w-full max-w-[700px] max-h-[90vh] overflow-y-auto rounded-3xl bg-white pt-5 pb-6 px-5 dark:bg-gray-900">

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
        <div class="space-y-6">

            <!-- Patient Identity -->
            <section>
                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Patient Identity</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="field in ['rm_number','identity_number','bpjs_number']" :key="field">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                                x-text="formatLabel(field)"></label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                                x-text="patient[field] ?? '-'"></p>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Personal Information -->
            <section>
                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Personal Information</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="field in ['first_name','last_name','gender','birth_place','birth_date']" :key="field">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                                x-text="formatLabel(field)"></label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                                x-text="patient[field] ?? '-'"></p>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Contact & Address -->
            <section>
                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Contact & Address</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="field in ['phone_number','street_address','city_address','state_address']" :key="field">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                                x-text="formatLabel(field)"></label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                                x-text="patient[field] ?? '-'"></p>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Emergency Contact -->
            <section>
                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Emergency Contact</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="field in ['emergency_full_name','emergency_phone_number']" :key="field">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                                x-text="formatLabel(field)"></label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                                x-text="patient[field] ?? '-'"></p>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Background & Health -->
            <section>
                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Background & Health</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="field in ['ethnic','education','married_status','job','father_name','mother_name','blood_type','communication_barrier','disability_status']" :key="field">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400"
                                x-text="formatLabel(field)"></label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100 text-sm border-b border-gray-200 dark:border-gray-700 pb-1" 
                                x-text="patient[field] ?? '-'"></p>
                        </div>
                    </template>
                </div>
            </section>

        </div>
    </div>
</div>