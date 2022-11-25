<div class="w-full px-4 flex">
    <div class="w-full lg:w-3/4 mx-auto mt-6 p-6 rounded bg-gray-50 grid grid-cols-1 gap-4">
        <h1 class="text-xl">@lang('trusted-devices::general.trusted_devices')</h1>

        @foreach($trustedDevices as $device)
            <div class="group rounded ring-1 ring-gray-300 bg-white text-sm flex justify-between relative cursor-pointer">
                <div class="flex">
                    <div class="w-20 flex justify-center items-center">
                        @switch($device->device_type)
                            @case('desktop')
                            <svg class="w-12 h-12 fill-gray-400" viewBox="0 0 24 24">
                                <path d="M21,16H3V4H21M21,2H3C1.89,2 1,2.89 1,4V16A2,2 0 0,0 3,18H10V20H8V22H16V20H14V18H21A2,2 0 0,0 23,16V4C23,2.89 22.1,2 21,2Z"/>
                            </svg>
                            @break
                            @case('phone')
                            <svg class="w-12 h-12 fill-gray-400" viewBox="0 0 24 24">
                                <path d="M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3C19,1.89 18.1,1 17,1Z"/>
                            </svg>
                            @break
                        @endswitch
                    </div>
                    <div class="p-4 grid grid-cols-1 gap-1">
                        @if($device->name)
                            <div>
                                <span class="font-bold text-lg">{{ $device->name }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="font-bold">{{ $device->device }}</span> ({{ $device->browser }})
                        </div>
                        <div>
                            {{ $device->ip }}
                        </div>
                        <div>
                            {{ $device->last_seen->diffForHumans() }}
                        </div>
                        @if($device->location())
                            <div>
                                {{ $device->location() ?? 'n/a' }}
                            </div>
                        @endif
                        @if($device->is_current)
                            <div class="flex">
                                <svg class="w-5 h-5 fill-blue-500 mr-2" viewBox="0 0 24 24">
                                    <path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"/>
                                </svg>

                                @lang('trusted-devices::general.current_session')
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-8 flex justify-center items-center">
                    <svg class="w-6 h-6 fill-gray-400 opacity-0 group-hover:opacity-100 transition duration-200" viewBox="0 0 24 24">
                        <path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z"/>
                    </svg>
                </div>

                <a href="{{ route('trusted-devices.edit', ['device' => $device->id]) }}" class="absolute top-0 right-0 bottom-0 left-0"></a>
            </div>
        @endforeach
    </div>
</div>