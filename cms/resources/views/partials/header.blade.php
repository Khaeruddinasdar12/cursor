@php
  $navItems = \App\Models\Menu::tree('header');
  $mobileItems = \App\Models\Menu::tree('mobile');
  $ctaLabel = setting('header_cta_label');
  $ctaUrl = site_url(setting('header_cta_url'));
@endphp
<!-- ══════════════ NAVBAR ══════════════ -->
<header id="nav" class="sticky top-0 z-50 glass border-b border-bone-100 shadow-[0_4px_24px_-12px_rgba(4,39,28,.25)] transition-all">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-[76px]">

      <!-- Brand -->
      <a href="{{ site_url('#beranda') }}" class="flex items-center gap-3 shrink-0 group">
        <div class="relative">
          <div class="w-12 h-12 rounded-full bg-gradient-to-br from-bone-700 to-bone-900 grid place-items-center ring-2 ring-gold-400 ring-offset-2 group-hover:scale-105 transition">
            @include('partials.logo')
          </div>
          <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-gold-400 ring-2 ring-white"></span>
        </div>
        <div class="leading-tight">
          <p class="font-extrabold text-bone-900 text-[17px] tracking-tight">{{ setting('brand_name') }} <span class="text-gold-600">{{ setting('brand_highlight') }}</span></p>
          <p class="text-[10.5px] text-slate-500 font-medium tracking-wide uppercase">{{ setting('brand_tagline') }}</p>
        </div>
      </a>

      <!-- Desktop menu -->
      <nav class="hidden lg:flex items-center gap-0.5 text-[14.5px] font-semibold text-bone-900">
        @foreach ($navItems as $item)
          @if ($item->activeChildren->isEmpty())
            <a href="{{ site_url($item->url) }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif class="px-3.5 py-2 rounded-lg hover:bg-bone-50 hover:text-bone-700 transition">{{ $item->label }}</a>
          @elseif ($item->isMega())
            <div class="nav-item relative">
              <button class="px-3.5 py-2 rounded-lg hover:bg-bone-50 hover:text-bone-700 transition flex items-center gap-1.5">
                {{ $item->label }} <i class="fa-solid fa-chevron-down text-[10px] opacity-60"></i>
              </button>
              <div class="nav-drop absolute left-1/2 -translate-x-1/2 top-full pt-2 w-[820px] max-w-[92vw]">
                <div class="bg-white rounded-3xl shadow-glow border border-bone-100 p-6 grid grid-cols-3 gap-6">
                  @foreach ($item->activeChildren->groupBy('column')->sortKeys() as $column)
                    <div>
                      @foreach ($column->groupBy(fn ($child) => (string) $child->group) as $group => $links)
                        @if ($loop->first)
                          @if ($group !== '')<p class="mega-col-title text-[11px] font-extrabold text-gold-600 uppercase mb-3">{{ $group }}</p>@endif
                          @foreach ($links as $link)
                            <a href="{{ site_url($link->url) }}" @if($link->open_in_new_tab) target="_blank" rel="noopener" @endif class="block py-1.5 text-[13.5px] font-medium text-slate-600 hover:text-bone-700 hover:translate-x-1 transition">{{ $link->label }}</a>
                          @endforeach
                        @else
                          <div class="mt-3 pt-3 border-t border-bone-100">
                            @if ($group !== '')<p class="mega-col-title text-[11px] font-extrabold text-gold-600 uppercase mb-2">{{ $group }}</p>@endif
                            @foreach ($links as $link)
                              <a href="{{ site_url($link->url) }}" @if($link->open_in_new_tab) target="_blank" rel="noopener" @endif class="block py-1.5 text-[13.5px] font-medium text-slate-600 hover:text-bone-700 hover:translate-x-1 transition">{{ $link->label }}</a>
                            @endforeach
                          </div>
                        @endif
                      @endforeach
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @else
            <div class="nav-item relative">
              <button class="px-3.5 py-2 rounded-lg hover:bg-bone-50 hover:text-bone-700 transition flex items-center gap-1.5">
                {{ $item->label }} <i class="fa-solid fa-chevron-down text-[10px] opacity-60"></i>
              </button>
              <div class="nav-drop absolute left-0 top-full pt-2 w-[260px]">
                <div class="bg-white rounded-2xl shadow-glow border border-bone-100 p-2">
                  @foreach ($item->activeChildren as $child)
                    <a href="{{ site_url($child->url) }}" @if($child->open_in_new_tab) target="_blank" rel="noopener" @endif class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-bone-50 group">
                      <i class="{{ $child->icon ?: 'fa-solid fa-angle-right' }} w-4 text-gold-500"></i><span class="group-hover:text-bone-700">{{ $child->label }}</span>
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </nav>

      <div class="flex items-center gap-2">
        <button id="openSearch" class="hidden sm:grid place-items-center w-10 h-10 rounded-full text-bone-800 hover:bg-bone-50 transition" aria-label="Cari">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if ($ctaLabel)
        <a href="{{ $ctaUrl }}" class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-bone-700 to-bone-600 text-white text-[14px] font-bold shadow-soft hover:shadow-glow hover:-translate-y-0.5 transition">
          <i class="fa-solid fa-paper-plane text-gold-300"></i> {{ $ctaLabel }}
        </a>
        @endif
        <button id="burger" class="lg:hidden grid place-items-center w-10 h-10 rounded-full text-bone-900 hover:bg-bone-50" aria-label="Menu">
          <i class="fa-solid fa-bars text-lg"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="lg:hidden hidden bg-white border-t border-bone-100 max-h-[75vh] overflow-y-auto">
    <div class="px-4 py-4 space-y-1 text-bone-900 font-semibold">
      @foreach ($mobileItems as $item)
        @if ($item->activeChildren->isEmpty())
          <a href="{{ site_url($item->url) }}" @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif class="block px-3 py-3 rounded-xl hover:bg-bone-50">{{ $item->label }}</a>
        @else
          <details class="group">
            <summary class="px-3 py-3 rounded-xl hover:bg-bone-50 cursor-pointer list-none flex justify-between items-center">{{ $item->label }} <i class="fa-solid fa-chevron-down text-xs group-open:rotate-180 transition"></i></summary>
            <div class="pl-4 pb-2 space-y-0.5 text-[14px] font-medium text-slate-600">
              @foreach ($item->activeChildren as $child)
                <a href="{{ site_url($child->url) }}" @if($child->open_in_new_tab) target="_blank" rel="noopener" @endif class="block px-3 py-2 rounded-lg hover:bg-bone-50">{{ $child->label }}</a>
              @endforeach
            </div>
          </details>
        @endif
      @endforeach
      @if ($ctaLabel)
        <a href="{{ $ctaUrl }}" class="mt-2 block text-center px-3 py-3 rounded-xl bg-bone-700 text-white">{{ $ctaLabel }}</a>
      @endif
    </div>
  </div>
</header>
