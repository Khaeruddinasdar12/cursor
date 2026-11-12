@php($topbarLinks = \App\Models\Menu::tree('topbar'))
<!-- ══════════════ TOP BAR ══════════════ -->
<div class="grad-bone text-bone-50 text-[13px]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2 py-2">
    <div class="flex items-center gap-4 flex-wrap">
      <span class="flex items-center gap-2"><i class="fa-solid fa-phone-volume text-gold-300"></i> {{ setting('contact_phone') }}</span>
      <span class="hidden sm:flex items-center gap-2"><i class="fa-solid fa-envelope text-gold-300"></i> {{ setting('contact_email') }}</span>
      <span class="hidden lg:flex items-center gap-2"><i class="fa-solid fa-location-dot text-gold-300"></i> {{ setting('contact_address_street') }}, {{ setting('contact_address_city') }}</span>
    </div>
    <div class="flex items-center gap-3">
      @foreach ($topbarLinks as $link)
        <a href="{{ site_url($link->url) }}" @if($link->open_in_new_tab) target="_blank" rel="noopener" @endif class="hover:text-gold-300 transition">{{ $link->label }}</a><span class="opacity-30">|</span>
      @endforeach
      <a href="{{ site_url(setting('topbar_lang_url')) }}" class="px-2.5 py-0.5 rounded-full bg-white/10 hover:bg-gold-400 hover:text-bone-950 transition font-semibold">{{ setting('topbar_lang_label') }}</a>
    </div>
  </div>
</div>
