@php
  $footerColumns = collect(['footer_profil', 'footer_layanan', 'footer_tautan'])
      ->map(fn ($slug) => \App\Models\Menu::query()->where('slug', $slug)->where('is_active', true)->first())
      ->filter();
  $footerLegal = \App\Models\Menu::tree('footer_legal');
  $socials = \App\Models\SocialLink::active()->ordered()->get();
@endphp
<!-- ══════════════ FOOTER ══════════════ -->
<footer id="kontak" class="bg-bone-950 text-bone-50/80 pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-12 gap-10 pb-12 border-b border-white/10">

      <div class="lg:col-span-4">
        <div class="flex items-center gap-3 mb-5">
          <div class="shrink-0">
            @include('partials.logo', ['class' => 'h-14 w-auto'])
          </div>
          <div>
            <p class="font-extrabold text-white text-[16px]">{{ setting('brand_name') }} {{ setting('brand_highlight') }}</p>
            <p class="text-[11.5px] tracking-wide uppercase text-bone-50/50">{{ setting('footer_brand_tagline') }}</p>
          </div>
        </div>
        <p class="text-[14.5px] leading-relaxed mb-5">
          {!! nl2br(e(setting('footer_description'))) !!}
        </p>
        <div class="flex gap-3">
          @foreach ($socials as $social)
            <a href="{{ site_url($social->url) }}" class="w-10 h-10 rounded-full bg-white/8 hover:bg-gold-400 hover:text-bone-950 grid place-items-center transition" aria-label="{{ $social->label }}"><i class="{{ $social->icon }}"></i></a>
          @endforeach
        </div>
      </div>

      @foreach ($footerColumns as $menu)
        <div class="lg:col-span-2">
          <p class="font-extrabold text-white text-[13px] tracking-[.14em] uppercase mb-5">{{ $menu->name }}</p>
          <ul class="space-y-3 text-[14.5px]">
            @foreach ($menu->items()->where('is_active', true)->get() as $link)
              <li><a href="{{ site_url($link->url) }}" @if($link->open_in_new_tab) target="_blank" rel="noopener" @endif class="hover:text-gold-300 transition">{{ $link->label }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach

      <div class="lg:col-span-2">
        <p class="font-extrabold text-white text-[13px] tracking-[.14em] uppercase mb-5">Kontak</p>
        <ul class="space-y-4 text-[14.5px]">
          <li class="flex gap-3"><i class="fa-solid fa-location-dot text-gold-400 mt-1"></i><span>{{ setting('contact_address_street') }}<br>{{ setting('contact_address_city') }}</span></li>
          <li class="flex gap-3"><i class="fa-solid fa-phone text-gold-400 mt-1"></i><span>{{ setting('contact_phone') }}</span></li>
          <li class="flex gap-3"><i class="fa-solid fa-fax text-gold-400 mt-1"></i><span>{{ setting('contact_fax') }}</span></li>
          <li class="flex gap-3"><i class="fa-solid fa-envelope text-gold-400 mt-1"></i><span>{{ setting('contact_email') }}</span></li>
          <li class="flex gap-3"><i class="fa-solid fa-globe text-gold-400 mt-1"></i><span>{{ setting('contact_website') }}</span></li>
        </ul>
      </div>
    </div>

    <div class="pt-7 flex flex-col sm:flex-row items-center justify-between gap-4 text-[13px] text-bone-50/55">
      <p>{{ setting('footer_copyright') }}</p>
      <div class="flex items-center gap-5">
        @foreach ($footerLegal as $link)
          <a href="{{ site_url($link->url) }}" @if($link->open_in_new_tab) target="_blank" rel="noopener" @endif class="hover:text-gold-300 transition">{{ $link->label }}</a>
        @endforeach
        <a href="{{ site_url('#beranda') }}" class="hover:text-gold-300 transition">{{ setting('footer_back_to_top') }} <i class="fa-solid fa-arrow-up text-[10px]"></i></a>
      </div>
    </div>
  </div>
</footer>
