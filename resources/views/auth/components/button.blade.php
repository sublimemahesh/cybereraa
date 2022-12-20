<div class="flex items-center justify-end mt-4">
    
    <button {{ $attribute }} type='submit' class='ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition  btn btn-primary btn-block btn btn-primary btn-block btn btn-primary btn-block'>
        {{ $slot }}
    </button><br>

    {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 " href="{{ route('login') }}">
        {{ __('Already registered?') }}
   </a> --}}
</div>