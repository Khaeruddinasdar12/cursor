@php
  $logo = setting('site_logo')
    ? \Illuminate\Support\Facades\Storage::disk('public')->url(setting('site_logo'))
    : asset('images/logo-iain-bone.png');
@endphp
<img src="{{ $logo }}" alt="{{ setting('brand_name') }}" class="{{ $class ?? 'h-12 w-auto' }} object-contain" />
