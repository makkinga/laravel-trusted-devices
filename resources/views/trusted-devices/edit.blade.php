<div x-data="{ deleteOpen: false }" class="w-full px-4 flex">
    <div class="w-full lg:w-3/4 mx-auto mt-6 p-6 rounded bg-gray-50">
        <a href="{{ route('trusted-devices.index') }}">
            <div class="mb-4 flex items-center">
                <svg class="w-5 fill-gray-600" viewBox="0 0 24 24">
                    <path d="M10.05 16.94V12.94H18.97L19 10.93H10.05V6.94L5.05 11.94Z"/>
                </svg>
                @lang('trusted-devices::general.back')
            </div>
        </a>
        <div class="rounded ring-1 ring-gray-300 bg-white flex grid grid-cols-1">
            <div class="flex">
                <div class="w-20 p-4 flex justify-center items-start">
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
                    <form class="mb-6" wire:submit.prevent="submit">
                        <div class="flex">

                            <input wire:model="device.name" type="text" placeholder="@lang('trusted-devices::general.name')" class="rounded ring-1 ring-gray-300">
                            <button type="submit" class="ml-4 px-4 rounded bg-blue-500 hover:bg-blue-400 text-white">@lang('trusted-devices::general.save')</button>

                            @if(session()->has('success'))
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 fill-green-500 ml-2" viewBox="0 0 24 24">
                                        <path d="M14 12.8C13.5 12.31 12.78 12 12 12C10.34 12 9 13.34 9 15C9 16.31 9.84 17.41 11 17.82C11.07 15.67 12.27 13.8 14 12.8M11.09 19H5V5H16.17L19 7.83V12.35C19.75 12.61 20.42 13 21 13.54V7L17 3H5C3.89 3 3 3.9 3 5V19C3 20.1 3.89 21 5 21H11.81C11.46 20.39 11.21 19.72 11.09 19M6 10H15V6H6V10M15.75 21L13 18L14.16 16.84L15.75 18.43L19.34 14.84L20.5 16.25L15.75 21"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </form>
                    <div>
                        <span class="font-bold">{{ $device->device }}</span> ({{ $device->browser }})
                    </div>
                    @if($device->is_current)
                        <div class="flex">
                            <svg class="w-5 h-5 fill-blue-500 mr-2" viewBox="0 0 24 24">
                                <path d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z"/>
                            </svg>

                            @lang('trusted-devices::general.current_session')
                        </div>
                    @endif
                    <div>
                        {{ $device->last_seen->diffForHumans() }}
                    </div>
                    <div class="mt-6 grid grid-cols-2">
                        @if($device->location())
                            <div class="font-bold">@lang('trusted-devices::general.location')</div>
                            <div>{{ $device->location() }}</div>
                        @endif
                        <div class="font-bold">@lang('trusted-devices::general.id')</div>
                        <div>{{ $device->id }}</div>
                        <div class="font-bold">@lang('trusted-devices::general.ip')</div>
                        <div>{{ $device->ip }}</div>
                        <div class="font-bold">@lang('trusted-devices::general.device')</div>
                        <div>{{ $device->device }}</div>
                        <div class="font-bold">@lang('trusted-devices::general.platform')</div>
                        <div>{{ $device->platform }}</div>
                        <div class="font-bold">@lang('trusted-devices::general.user_agent')</div>
                        <div>{{ $device->user_agent }}</div>
                    </div>
                </div>
            </div>
            <div class="p-4 flex justify-end">
                <button @click="deleteOpen = true" type="button" class="ml-4 p-2 rounded bg-red-500 hover:bg-red-400 text-white">@lang('trusted-devices::general.delete_trusted_device')</button>
            </div>
        </div>
    </div>

    <div x-show="deleteOpen" class="fixed z-50 absolute top-0 right-0 bottom-0 left-0 flex justify-center items-center">
        <div class="w-1/3 rounded bg-white ring-1 ring-gray-200 shadow-xl">
            <div class="p-2 flex justify-end">
                <svg @click="deleteOpen = false" class="w-4 h-4 fill-gray-400 cursor-pointer" viewBox="0 0 24 24">
                    <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                </svg>
            </div>
            <div class="p-6 pt-2">
                <div class="mb-4 font-bold text-xl">{!! trans('trusted-devices::general.delete_modal_title', ['address' => $device->ip, 'name' => $device->name]) !!}</div>
                <p>{!! trans('trusted-devices::general.delete_modal_body', ['address' => $device->ip, 'name' => $device->name]) !!}</p>
                <div class="mt-6 flex">
                    <input wire:model="deleteConfirmation" type="text" placeholder="{{ $device->ip }}" class="w-full rounded ring-1 ring-gray-300">
                    <form wire:submit.prevent="delete">
                        @if($deleteConfirmation === $device->ip)
                            <button type="submit" class="ml-4 p-2 rounded bg-red-500 hover:bg-red-400 text-white cursor-pointer">@lang('trusted-devices::general.delete')</button>
                        @else
                            <button type="button" disabled class="ml-4 p-2 rounded bg-gray-300 text-gray-600 cursor-not-allowed">@lang('trusted-devices::general.delete')</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>