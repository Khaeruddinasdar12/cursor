<section class="relative grad-bone pattern-islamic text-white overflow-hidden">
  <div class="absolute -top-24 -right-24 w-[420px] h-[420px] rounded-full bg-gold-400/20 blur-3xl"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">
    <nav class="text-[13px] text-bone-50/70 mb-4 flex flex-wrap items-center gap-2">
      <a href="{{ route('home') }}" class="hover:text-gold-300 transition">Beranda</a>
      <i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>
      @isset($parent)
        <a href="{{ $parent['url'] }}" class="hover:text-gold-300 transition">{{ $parent['label'] }}</a>
        <i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>
      @endisset
      <span class="text-gold-300">{{ $crumb }}</span>
    </nav>
    <h1 class="font-display font-extrabold text-[30px] sm:text-[40px] leading-tight tracking-tight max-w-4xl">{{ $title }}</h1>
    @isset($meta)<div class="mt-5 flex flex-wrap items-center gap-3 text-[13px]">{{ $meta }}</div>@endisset
  </div>
</section>
