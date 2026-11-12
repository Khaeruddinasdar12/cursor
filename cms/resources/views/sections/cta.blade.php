<!-- ══════════════ LAYANAN (CTA) ══════════════ -->
<section id="layanan" class="relative grad-bone pattern-islamic py-20 lg:py-24 text-white overflow-hidden">
  <div class="absolute -bottom-28 -right-20 w-[440px] h-[440px] rounded-full bg-gold-400/20 blur-3xl"></div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
    <div data-aos="fade-right">
      <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-400 uppercase mb-3">{{ setting('cta_eyebrow') }}</p>
      <h2 class="font-display font-extrabold text-[32px] sm:text-[40px] leading-tight mb-5">
        {{ setting('cta_title') }}
      </h2>
      <p class="text-[16px] leading-relaxed text-bone-50/80 mb-8">
        {{ setting('cta_description') }}
      </p>
      <div class="flex flex-wrap gap-3.5">
        <a href="{{ site_url(setting('cta_button1_url')) }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-gold-400 text-bone-950 font-bold text-[15px] shadow-soft hover:bg-gold-300 hover:-translate-y-0.5 transition">
          <i class="fa-solid fa-arrow-right-to-bracket"></i> {{ setting('cta_button1_label') }}
        </a>
        <a href="{{ site_url(setting('cta_button2_url')) }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-white/10 border border-white/25 backdrop-blur font-bold text-[15px] hover:bg-white/20 transition">
          <i class="fa-solid fa-download text-gold-300"></i> {{ setting('cta_button2_label') }}
        </a>
      </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-4" data-aos="fade-left" data-aos-delay="120">
      @foreach ($ctaLinks as $link)
      <a href="{{ site_url($link->url) }}" class="p-5 rounded-2xl bg-white/8 border border-white/15 backdrop-blur hover:bg-white/15 transition group">
        <i class="{{ $link->icon }} text-gold-300 text-lg"></i>
        <p class="font-bold mt-3 text-[15px]">{{ $link->title }}</p>
        <p class="text-[13px] text-bone-50/70 mt-1">{{ $link->subtitle }}</p>
      </a>
      @endforeach
    </div>
  </div>
</section>
