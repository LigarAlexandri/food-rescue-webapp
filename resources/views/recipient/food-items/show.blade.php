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