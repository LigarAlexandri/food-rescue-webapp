<x-guest-layout> {{-- Or your main app layout if you want nav for unauthenticated users --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-semibold">Welcome to Food Rescue Platform!</h1>
                    <p class="mt-4">Connecting surplus food with those in need.</p>

                    @guest
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
                        <span class="mx-2">|</span>
                        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                    </div>
                    @endguest

                    @auth
                        <p class="mt-4">You are logged in. Go to your dashboard.</p>
                        @if(Auth::user()->role === 'vendor')
                            <a href="{{ route('vendor.dashboard') }}" class="text-blue-500 hover:underline">Vendor Dashboard</a>
                        @elseif(Auth::user()->role === 'recipient')
                            <a href="{{ route('recipient.dashboard') }}" class="text-blue-500 hover:underline">Recipient Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">Dashboard</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
