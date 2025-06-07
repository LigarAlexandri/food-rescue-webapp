<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Users</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $stats['total_users'] }}</p>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p>Vendors: {{ $stats['total_vendors'] }}</p>
                        <p>Recipients: {{ $stats['total_recipients'] }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Food Items</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-700 dark:text-gray-200">{{ $stats['total_food_items'] }}</p>
                     <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p>Available: {{ $stats['available_items'] }}</p>
                        <p>Claimed: {{ $stats['claimed_items'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>