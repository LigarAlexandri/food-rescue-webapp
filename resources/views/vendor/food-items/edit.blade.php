<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Food Item') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vendor.food-items.update', $foodItem->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Food Item Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $foodItem->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $foodItem->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="quantity" :value="__('Quantity (e.g., 3 porsi, 5 buah)')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="text" name="quantity" :value="old('quantity', $foodItem->quantity)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="pickup_location" :value="__('Pickup Location/Instructions')" />
                            <x-text-input id="pickup_location" class="block mt-1 w-full" type="text" name="pickup_location" :value="old('pickup_location', $foodItem->pickup_location)" required />
                            <x-input-error :messages="$errors->get('pickup_location')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="pickup_start_time" :value="__('Pickup Start Time')" />
                            <x-text-input id="pickup_start_time" class="block mt-1 w-full" type="datetime-local" name="pickup_start_time" :value="old('pickup_start_time', $foodItem->pickup_start_time ? $foodItem->pickup_start_time->format('Y-m-d\TH:i') : '')" required />
                            <x-input-error :messages="$errors->get('pickup_start_time')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="pickup_end_time" :value="__('Pickup End Time')" />
                            <x-text-input id="pickup_end_time" class="block mt-1 w-full" type="datetime-local" name="pickup_end_time" :value="old('pickup_end_time', $foodItem->pickup_end_time ? $foodItem->pickup_end_time->format('Y-m-d\TH:i') : '')" required />
                            <x-input-error :messages="$errors->get('pickup_end_time')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="available" {{ old('status', $foodItem->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ old('status', $foodItem->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                {{-- Vendor cannot directly set to claimed, completed, expired from this edit form's status dropdown. Those are handled by other actions. --}}
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Food Image (Optional)')" />
                            <input id="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="image">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            @if($foodItem->image_url)
                                <div class="mt-2">
                                    <img src="{{ $foodItem->image_url }}" alt="{{ $foodItem->name }}" class="h-20 w-auto rounded">
                                    <p class="text-xs text-gray-500">Current image. Upload a new one to replace it.</p>
                                </div>
                            @endif
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('vendor.dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>