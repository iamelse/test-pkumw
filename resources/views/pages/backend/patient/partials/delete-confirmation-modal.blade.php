<div x-show="modals.delete" x-transition.opacity 
    class="fixed inset-0 z-[99999] flex items-center justify-center p-5 overflow-y-auto">

    <!-- Overlay -->
    <div @click="closeModal('delete')" 
        class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[6px]">
    </div>

    <!-- Modal Box -->
    <div @click.outside="closeModal('delete')" x-transition
        class="relative w-full max-w-md rounded-3xl bg-white p-6 dark:bg-gray-900">

        <!-- Header -->
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            Confirm Deletion
        </h2>

        <!-- Message -->
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Are you sure you want to delete 
            <span class="font-medium" x-text="deletePatientName"></span>?
        </p>

        <!-- Actions -->
        <div class="mt-4 flex justify-end gap-3">

            <!-- Cancel Button -->
            <button @click="closeModal('delete')" 
                class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 
                       dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                Cancel
            </button>

            <!-- Delete Form -->
            <form :action="'{{ route('be.patient.destroy', ':id') }}'.replace(':id', deletePatientId)" 
                method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                    Delete
                </button>
            </form>

        </div>
    </div>
</div>