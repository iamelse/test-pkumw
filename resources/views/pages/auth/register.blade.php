@extends('layouts.auth')

@section('content')
    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
      <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">
        <!-- Form -->
        <div class="flex flex-col flex-1 w-full lg:w-1/2">
          <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
            <div>
              <div class="mb-5 sm:mb-8">
                <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                  Sign Up
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  Create a new account to access the dashboard.
                </p>
              </div>

              <div>
                <form action="{{ route('auth.register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-5">

                        <!-- Profile Photo (Centered + Clickable + X Button) -->
                        <div x-data="{ previewUrl: null }" class="flex flex-col items-center relative">
                            <!-- Wrapper dengan posisi relative supaya tombol X bisa absolute -->
                            <div class="relative">
                                <label for="photo-input" class="cursor-pointer group block">
                                    <!-- Avatar Preview / Placeholder -->
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl"
                                            alt="Preview"
                                            class="w-24 h-24 rounded-full object-cover border border-gray-300 dark:border-gray-700 group-hover:opacity-80 transition">
                                    </template>

                                    <template x-if="!previewUrl">
                                        <div class="w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 flex items-center justify-center text-gray-400 text-xs text-center px-2 group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition">
                                            Click to Upload
                                        </div>
                                    </template>
                                </label>

                                <!-- X Button di pojok kanan atas -->
                                <button type="button"
                                        x-show="previewUrl"
                                        @click="previewUrl = null; $refs.photoInput.value = ''"
                                        x-transition
                                        class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white flex items-center justify-center shadow hover:bg-red-600 transition">
                                    &times;
                                </button>
                            </div>

                            <!-- Hidden Input -->
                            <input type="file"
                                id="photo-input"
                                x-ref="photoInput"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                @change="previewUrl = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null">

                            @error('photo')
                                <p class="mt-2 text-xs font-semibold text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Full Name <span class="text-error-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                class="h-11 w-full rounded-lg border
                                    @error('name')
                                        border-error-500 focus:border-error-500 focus:ring-error-500/20
                                    @else
                                        border-gray-300 focus:border-brand-300 focus:ring-brand-500/10
                                    @enderror
                                    bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs
                                    placeholder:text-gray-400 focus:outline-hidden focus:ring-3
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required
                            />
                            @error('name')
                                <p class="mt-1 text-xs fw-bold text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email <span class="text-error-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@pkuwsb.id"
                                class="h-11 w-full rounded-lg border
                                    @error('email')
                                        border-error-500 focus:border-error-500 focus:ring-error-500/20
                                    @else
                                        border-gray-300 focus:border-brand-300 focus:ring-brand-500/10
                                    @enderror
                                    bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs
                                    placeholder:text-gray-400 focus:outline-hidden focus:ring-3
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required
                            />
                            @error('email')
                                <p class="mt-1 text-xs fw-bold text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ showPassword: false }" class="relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    class="h-11 w-full rounded-lg border
                                        @error('password') border-error-500 focus:border-error-500 focus:ring-error-500/20
                                        @else border-gray-300 focus:border-brand-300 focus:ring-brand-500/10 @enderror
                                        bg-transparent py-2.5 pl-4 pr-11 text-sm text-gray-800 shadow-theme-xs
                                        placeholder:text-gray-400 focus:outline-hidden focus:ring-3
                                        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    required
                                />
                                <span @click="showPassword = !showPassword"
                                    class="absolute z-30 text-gray-500 -translate-y-1/2 cursor-pointer right-4 top-1/2 dark:text-gray-400">
                                    <!-- Eye icons -->
                                    <!-- sama seperti login, tidak perlu diubah -->
                                </span>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs fw-bold text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Confirm Password <span class="text-error-500">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                class="h-11 w-full rounded-lg border
                                    border-gray-300 focus:border-brand-300 focus:ring-brand-500/10
                                    bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs
                                    placeholder:text-gray-400 focus:outline-hidden focus:ring-3
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required
                            />
                        </div>

                        <!-- Button -->
                        <div>
                            <button type="submit"
                                    class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                Sign Up
                            </button>
                        </div>

                        <div class="text-sm text-center text-gray-500 dark:text-gray-400">
                            Already have an account?
                            <a href="{{ route('auth.login') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">
                                Sign In
                            </a>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Side Image/Shape -->
        <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:grid lg:w-1/2">
          <div class="flex items-center justify-center z-1">
            @include('components.common-grid-shape')
            <div class="flex flex-col items-center max-w-xs">
              <a href="index.html" class="block mb-4">
                <img src="{{ asset('assets/images/logo/auth-logo.svg') }}" alt="Logo" />
              </a>
              <p class="text-center text-gray-400 dark:text-white/60">
                Free and Open-Source Tailwind CSS Admin Dashboard Template
              </p>
            </div>
          </div>
        </div>

        <!-- Dark Mode Toggler -->
        <div class="fixed z-50 hidden bottom-6 right-6 sm:block">
          <!-- Sama seperti di login -->
        </div>
      </div>
    </div>
@endsection