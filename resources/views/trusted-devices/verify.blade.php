<div class="w-full flex">
    <div class="w-1/2 mx-auto mt-6 p-6 rounded bg-gray-50 grid grid-cols-1 gap-4">
        <h1 class="text-xl">@lang('trusted-devices::general.device_verification')</h1>

        @if($verified)
            <div class="p-4 rounded bg-green-200 text-green-600">@lang('trusted-devices::general.verification_successful')</div>
        @else
            <div class="p-4 rounded bg-red-200 text-red-600">@lang('trusted-devices::general.something_went_wrong')</div>
        @endif

        <a href="{{ \App\Providers\RouteServiceProvider::HOME }}" class="w-fit p-2 rounded bg-sky-500 hover:bg-sky-600 text-white cursor-pointer">@lang('trusted-devices::general.continue')</a>
    </div>
</div>