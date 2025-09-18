@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto w-full md:p-6 space-y-10">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ getGreeting() }}, {{ getFirstName(Auth::user()->name) }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Dashboard shows stats based on your own activity.
                    </p>
                </div>
            </div>
    </div>
@endsection