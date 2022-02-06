<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <br><br>
                    <div>
                        <h2>{{$date}}</h2>
                    </div>
                    <div>
                        @if ($entry == null)
                            <a href="check-in" class="btn btn-primary">Check In</a>
                        @elseif ($entry->checkout_at)
                            <h3>Thank you, Check out successfully!</h3>
                        @else
                            <a href="check-out" class="btn btn-primary">Check Out</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
