<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Claimed Food Items') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif
            @if($claimedItems->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>You have not claimed any food items yet.</p>
                        <a href="{{route('recipient.dashboard')}}" class="text-indigo-600 hover:underline">Browse available items</a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($claimedItems as $item)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-6 flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">From: {{ $item->vendor->shop_name ?? $item->vendor->name }}</p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-300">
                                Pickup: {{ $item->pickup_start_time->format('M d, H:i') }} - {{ $item->pickup_end_time->format('H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-300">Location: {{ Str::limit($item->pickup_location, 50) }}</p>
                            <p class="mt-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($item->status === 'claimed') bg-yellow-100 text-yellow-800 @else bg-blue-100 text-blue-800 @endif">
                                    Status: {{ ucfirst($item->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                             <a href="{{ route('recipient.food-items.show', $item->id) }}" class="w-full text-center inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6">
                    {{ $claimedItems->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>