<!-- ══════════════ JURNAL / PUBLIKASI ══════════════ -->
<section id="jurnal" class="py-20 lg:py-28 bg-bone-900 pattern-islamic text-white relative overflow-hidden">
  <div class="absolute top-0 right-0 w-[420px] h-[420px] rounded-full bg-bone-600/25 blur-3xl"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-end justify-between gap-6 mb-12" data-aos="fade-up">
      <div class="max-w-2xl">
        <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-400 uppercase mb-3">{{ setting('publications_eyebrow') }}</p>
        <h2 class="font-display font-extrabold text-[32px] sm:text-[40px] leading-tight mb-4">{{ setting('publications_title') }}</h2>
        <p class="text-[16px] leading-relaxed text-bone-50/75">
          {{ setting('publications_description') }}
        </p>
      </div>
      <a href="{{ site_url(setting('publications_button_url')) }}" class="inline-flex items-center gap-2.5 px-6 py-3 rounded-full bg-white/10 border border-white/25 backdrop-blur font-bold text-[15px] hover:bg-white/20 transition">
        <i class="fa-solid fa-up-right-from-square text-gold-300"></i> {{ setting('publications_button_label') }}
      </a>
    </div>

    <div class="swiper journalSwiper pb-14" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper-wrapper">
        @foreach ($publications as $item)
        <div class="swiper-slide h-auto">
          <article class="h-full bg-white/5 border border-white/12 rounded-3xl p-7 backdrop-blur hover:bg-white/10 transition flex flex-col">
            <div class="flex items-center gap-3 mb-5">
              <div class="w-12 h-12 rounded-xl bg-gold-400 grid place-items-center text-bone-950"><i class="{{ $item->icon }}"></i></div>
              <span class="text-[11px] font-extrabold tracking-wide px-2.5 py-1 rounded-full bg-white/10 text-gold-300">{{ $item->badge }}</span>
            </div>
            <h3 class="font-extrabold text-[17px] mb-2.5 leading-snug">@if($item->url)<a href="{{ site_url($item->url) }}">{{ $item->title }}</a>@else{{ $item->title }}@endif</h3>
            <p class="text-[14px] leading-relaxed text-bone-50/70 flex-1">{{ $item->description }}</p>
            <div class="mt-5 pt-5 border-t border-white/10 flex items-center justify-between text-[12.5px] text-bone-50/60">
              <span><i class="{{ $item->meta_icon }} mr-1.5 text-gold-300"></i>{{ $item->meta_label }}</span>
              <span class="font-bold text-gold-300">{{ $item->meta_value }}</span>
            </div>
          </article>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination !bottom-0"></div>
    </div>
  </div>
</section>
