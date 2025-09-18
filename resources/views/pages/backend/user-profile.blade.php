@extends('layouts.app')

@section('content')
<div x-data="{ isProfileInfoModal: false }" class="p-4 mx-auto w-full md:p-6 space-y-10">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Your Profile
            </h1>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 lg:mb-7 dark:text-white/90">
            Profile
        </h3>

        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                    <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
                        <img src="{{ getUserImageProfilePath(Auth::user()) }}" alt="user">
                    </div>
                    <div class="order-3 xl:order-2">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                            {{ Auth::user()->name }}
                        </h4>
                        <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ Auth::user()->username ?? 'No username set' }}
                            </p>
                            <div class="hidden h-3.5 w-px bg-gray-300 xl:block dark:bg-gray-700"></div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Button -->
                <button @click="isProfileInfoModal = true" class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"></path>
                    </svg>
                    Edit
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div x-show="isProfileInfoModal" x-transition.opacity class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto z-[99999]">
        <!-- Backdrop -->
        <div @click="isProfileInfoModal = false" class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>

        <!-- Modal Content -->
        <div @click.outside="isProfileInfoModal = false" x-transition class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
            <!-- Close Button -->
            <button @click="isProfileInfoModal = false" class="transition-color absolute right-5 top-5 z-50 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-700 dark:bg-white/[0.05] dark:text-gray-400 dark:hover:bg-white/[0.07] dark:hover:text-gray-300">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"></path>
                </svg>
            </button>

            <div class="px-2 pr-14">
                <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                    Edit Personal Information
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                    Update your details to keep your profile up-to-date.
                </p>
            </div>

            <form 
                method="POST" 
                action="{{ route('be.user_profile.update') }}" 
                enctype="multipart/form-data" 
                class="flex flex-col"
                x-data="{ previewPhoto: null }"
            >
                @csrf
                @method('PUT')

                <div class="custom-scrollbar h-[450px] overflow-y-auto px-2 space-y-8">

                    <!-- Personal Information Section -->
                    <div>
                        <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90">
                            Personal Information
                        </h5>

                        <!-- Profile Photo -->
                        <div class="flex flex-col items-center mb-6 relative">
                            <div class="relative">
                                <!-- Clickable Profile Image -->
                                <label for="photoInput" class="cursor-pointer">
                                    <img 
                                        :src="previewPhoto || '{{ getUserImageProfilePath(Auth::user()) }}'" 
                                        class="w-24 h-24 rounded-full object-cover border hover:opacity-80 transition"
                                        alt="Profile Preview"
                                    >
                                </label>

                                <!-- Remove Button (X) -->
                                <button 
                                    type="button"
                                    @click="
                                        previewPhoto = '{{ avatar_placeholder(Auth::user()->name) }}'; // ganti default
                                        document.getElementById('photoInput').value = '';
                                        $refs.removePhoto.value = '1';
                                    "
                                    class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 text-white shadow-md"
                                    title="Remove Photo"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Hidden File Input -->
                            <input 
                                id="photoInput"
                                type="file" 
                                name="photo" 
                                class="hidden"
                                accept="image/*"
                                @change="
                                    let file = $event.target.files[0]; 
                                    if (file) { 
                                        previewPhoto = URL.createObjectURL(file); 
                                        $refs.removePhoto.value = '0'; 
                                    }
                                "
                            >

                            <!-- Hidden input to mark photo removal -->
                            <input type="hidden" name="remove_photo" x-ref="removePhoto" value="0">

                            @error('photo')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Name, Username, Email -->
                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', Auth::user()->name) }}"
                                    placeholder="Enter your full name"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-theme-xs 
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                            </div>

                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Username <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="username" 
                                    value="{{ old('username', Auth::user()->username) }}"
                                    placeholder="Choose a unique username"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-theme-xs 
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                            </div>

                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', Auth::user()->email) }}"
                                    placeholder="you@pkuwsb.id"
                                    pattern="^[a-zA-Z0-9._%+\-]+@pkuwsb\.id$"
                                    required
                                    class="h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-theme-xs 
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="mt-8">
                        <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                            Change Password
                        </h5>

                        <div class="grid grid-cols-1 gap-y-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    New Password <span class="text-xs text-gray-500">(leave blank to keep current password)</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password"
                                    placeholder="Enter new password"
                                    class="h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-theme-xs 
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Confirm Password
                                </label>
                                <input 
                                    type="password" 
                                    name="password_confirmation"
                                    placeholder="Confirm new password"
                                    class="h-11 w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm shadow-theme-xs 
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                >
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                    <button 
                        @click="isProfileInfoModal = false" 
                        type="button" 
                        class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 
                            text-sm font-medium text-gray-700 hover:bg-gray-50 sm:w-auto"
                    >
                        Close
                    </button>

                    <button 
                        type="submit" 
                        class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 
                            text-sm font-medium text-white hover:bg-brand-600 sm:w-auto"
                    >
                        Save Changes
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection
