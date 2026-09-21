@props(['ttl'])
@aware(['secondsOnly'])

<span {{ $attributes->merge([
    'class' => '',
    'data-ttl' => $ttl
]) }}  x-data='timer' x-cloak wire:ignore></span>

@assets
    <script src="{{ package_asset('js/otp-timer.js') }}"></script>
@endassets