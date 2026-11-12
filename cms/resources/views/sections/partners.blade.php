<!-- ══════════════ KEMITRAAN ══════════════ -->
<section id="kemitraan" class="py-20 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-12" data-aos="fade-up">
      <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-3">{{ setting('partners_eyebrow') }}</p>
      <h2 class="font-display font-extrabold text-[30px] sm:text-[36px] text-bone-900 mb-4">{{ setting('partners_title') }}</h2>
      <p class="text-[16px] text-slate-600 leading-relaxed">{{ setting('partners_description') }}</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4" data-aos="fade-up" data-aos-delay="100">
      @foreach ($partners as $partner)
      @php($tag = $partner->url ? 'a' : 'div')
      <{{ $tag }} @if($partner->url) href="{{ site_url($partner->url) }}" target="_blank" rel="noopener" @endif class="grid place-items-center h-24 rounded-2xl border border-bone-100 bg-bone-50/60 text-bone-800 font-bold text-[13px] text-center px-3 hover:border-gold-400 hover:shadow-soft transition">
        @if ($partner->logo)
          <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo) }}" alt="{{ str_replace("\n", ' ', $partner->name) }}" class="max-h-16 w-auto object-contain" loading="lazy">
        @else
          {!! nl2br(e($partner->name)) !!}
        @endif
      </{{ $tag }}>
      @endforeach
    </div>

    <div class="mt-10 text-center" data-aos="fade-up" data-aos-delay="160">
      <a href="{{ site_url(setting('partners_button_url')) }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full border-2 border-bone-700 text-bone-800 font-bold text-[15px] hover:bg-bone-700 hover:text-white transition">
        <i class="fa-solid fa-handshake"></i> {{ setting('partners_button_label') }}
      </a>
    </div>
  </div>
</section>
