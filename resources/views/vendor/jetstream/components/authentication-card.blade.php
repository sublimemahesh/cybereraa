<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full {{--sm:max-w-md--}} w-1/2 mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg col-span-8">
        {{ $slot }}
    </div>
</div>
