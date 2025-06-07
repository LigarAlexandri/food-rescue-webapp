<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $foodItem->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($foodItem->image_url)
                    <img src="{{ $foodItem->image_url }}" alt="{{ $foodItem->name }}" class="w-full h-64 object-cover">
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Listed by: <strong>{{ $foodItem->vendor->shop_name ?? $foodItem->vendor->name }}</strong></p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Quantity: <strong>{{ $foodItem->quantity }}</strong></p>

                    @if($foodItem->description)
                        <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $foodItem->description }}</p>
                    @endif

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="font-semibold">Pickup Details:</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Location: {{ $foodItem->pickup_location }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Time: {{ $foodItem->pickup_start_time->format('D, M j, Y, g:i A') }} to {{ $foodItem->pickup_end_time->format('g:i A') }}
                        </p>
                    </div>

                    {{-- WhatsApp Contact Button --}}
                    @if($foodItem->vendor->whatsapp_number)
                        <div class="mt-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $foodItem->vendor->whatsapp_number) }}" target="_blank" class="w-full justify-center inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.487 5.235 3.487 8.413-.003 6.557-5.338 11.892-11.894 11.892-1.99 0-3.903-.52-5.58-1.452l-6.344 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.447-4.433-9.886-9.888-9.886-5.448 0-9.886 4.434-9.889 9.885-.002 2.021.57 3.939 1.632 5.632l-1.005 3.655 3.745-1.001z"/></svg>
                                Contact Vendor on WhatsApp
                            </a>
                        </div>
                    @endif

                    <div class="mt-6">
                        @if($foodItem->status === 'available' && $foodItem->pickup_end_time > now())
                            <form action="{{ route('recipient.food-items.claim', $foodItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to claim this item? You will be expected to pick it up.');">
                                @csrf
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Claim This Item') }}
                                </x-primary-button>
                            </form>
                        @elseif($foodItem->status === 'claimed')
                            @if($foodItem->claimed_by_recipient_id === Auth::id())
                                <p class="p-3 text-center bg-yellow-100 text-yellow-700 rounded-md">You have claimed this item. Please pick it up as per the details.</p>
                            @else
                                <p class="p-3 text-center bg-red-100 text-red-700 rounded-md">This item has already been claimed by someone else.</p>
                            @endif
                        @elseif($foodItem->status === 'completed')
                            <p class="p-3 text-center bg-blue-100 text-blue-700 rounded-md">This item has been picked up.</p>
                        @else
                            <p class="p-3 text-center bg-gray-100 text-gray-700 rounded-md">This item is currently {{ $foodItem->status }}.</p>
                        @endif
                    </div>
                     <div class="mt-4 text-center">
                        <a href="{{ route('recipient.dashboard') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                            &larr; Back to Available Items
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
