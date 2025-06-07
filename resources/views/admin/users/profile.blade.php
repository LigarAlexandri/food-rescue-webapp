<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            User Profile: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Name</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Email</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                         <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Role</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($user->role) }}</p>
                        </div>

                        {{-- Vendor Specific Info --}}
                        @if($user->role === 'vendor')
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Shop Name</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->shop_name ?? 'Not Provided' }}</p>
                            </div>
                             <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Address</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->address ?? 'Not Provided' }}</p>
                            </div>
                        @endif

                        @if($user->whatsapp_number)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">WhatsApp Number</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->whatsapp_number }}</p>
                                <div class="mt-2">
                                     <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->whatsapp_number) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Contact on WhatsApp
                                    </a>
                                </div>
                            </div>
                        @endif

                         <div class="mt-6 border-t pt-4">
                            <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:underline">
                                &larr; Back to All Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
