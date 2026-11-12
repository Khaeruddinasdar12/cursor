<!-- ══════════════ PUSAT LAYANAN ══════════════ -->
<section id="pusat" class="py-20 lg:py-28 bg-bone-50 relative overflow-hidden">
  <div class="absolute inset-0 pattern-light opacity-70 pointer-events-none"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
      <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-3">{{ setting('centers_eyebrow') }}</p>
      <h2 class="font-display font-extrabold text-[32px] sm:text-[40px] leading-tight text-bone-900 mb-4">{{ setting('centers_title') }}</h2>
      <p class="text-[16px] text-slate-600 leading-relaxed">
        {{ setting('centers_description') }}
      </p>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach ($centers as $center)
      @php($delay = ($loop->index % 3) * 80)
      <div class="card-lift group bg-white rounded-3xl border border-bone-100 shadow-soft overflow-hidden" data-aos="fade-up"@if($delay) data-aos-delay="{{ $delay }}"@endif>
        <div class="h-2 grad-bone"></div>
        <div class="p-7">
          <div class="flex items-start justify-between mb-5">
            <div class="w-14 h-14 rounded-2xl bg-bone-50 border border-bone-100 grid place-items-center text-bone-700 group-hover:bg-bone-700 group-hover:text-gold-300 transition">
              <i class="{{ $center->icon }} text-xl"></i>
            </div>
            <span class="text-[11px] font-extrabold tracking-wide px-3 py-1 rounded-full bg-gold-100 text-gold-700">{{ $center->badge }}</span>
          </div>
          <h3 class="font-extrabold text-[18px] text-bone-900 mb-3 leading-snug">{{ $center->title }}</h3>
          <ul class="space-y-2 text-[14px] text-slate-600 mb-5">
            @foreach ($center->features ?? [] as $feature)
            <li class="flex gap-2.5"><i class="fa-solid fa-circle-check text-bone-500 mt-1 text-xs"></i>{{ is_array($feature) ? ($feature['text'] ?? '') : $feature }}</li>
            @endforeach
          </ul>
          <a href="{{ site_url($center->link_url) }}" class="inline-flex items-center gap-2 text-[14px] font-bold text-bone-700 hover:text-gold-600 transition">{{ $center->link_label }} <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition"></i></a>
        </div>
      </div>
      @endforeach

      <!-- CTA -->
      @php($ctaDelay = ($centers->count() % 3) * 80)
      <div class="card-lift grad-bone pattern-islamic rounded-3xl p-7 text-white flex flex-col justify-between" data-aos="fade-up"@if($ctaDelay) data-aos-delay="{{ $ctaDelay }}"@endif>
        <div>
          <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 grid place-items-center text-gold-300 mb-5">
            <i class="fa-solid fa-headset text-xl"></i>
          </div>
          <h3 class="font-extrabold text-[18px] mb-3 leading-snug">{{ setting('centers_cta_title') }}</h3>
          <p class="text-[14px] leading-relaxed text-bone-50/80 mb-6">
            {{ setting('centers_cta_text') }}
          </p>
        </div>
        <a href="{{ site_url(setting('centers_cta_button_url')) }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-gold-400 text-bone-950 font-bold text-[14.5px] hover:bg-gold-300 transition">
          <i class="fa-solid fa-comments"></i> {{ setting('centers_cta_button_label') }}
        </a>
      </div>
    </div>
  </div>
</section>
