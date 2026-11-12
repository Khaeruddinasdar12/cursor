@if (setting('site_logo'))
  <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(setting('site_logo')) }}" alt="{{ setting('brand_name') }}" class="w-7 h-7 object-contain" />
@elseif ($footer ?? false)
  <svg viewBox="0 0 100 100" class="w-7 h-7" aria-hidden="true">
    <path d="M50 14 L78 38 V82 H22 V38 Z" fill="none" stroke="#f4d94f" stroke-width="4.5" stroke-linejoin="round"/>
    <circle cx="50" cy="62" r="9" fill="none" stroke="#f4d94f" stroke-width="3"/>
  </svg>
@else
  <svg viewBox="0 0 100 100" class="w-7 h-7" aria-hidden="true">
    <path d="M50 14 L78 38 V82 H22 V38 Z" fill="none" stroke="#f4d94f" stroke-width="4.5" stroke-linejoin="round"/>
    <path d="M22 46 H78 M50 14 V82" stroke="#f4d94f" stroke-width="3" opacity=".8"/>
    <circle cx="50" cy="62" r="9" fill="none" stroke="#f4d94f" stroke-width="3"/>
  </svg>
@endif
