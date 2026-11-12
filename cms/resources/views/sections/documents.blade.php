<!-- ══════════════ DOKUMEN & UNDUHAN ══════════════ -->
<section id="dokumen" class="py-20 lg:py-28 bg-white pattern-light">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-14" data-aos="fade-up">
      <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-3">{{ setting('documents_eyebrow') }}</p>
      <h2 class="font-display font-extrabold text-[32px] sm:text-[40px] leading-tight text-bone-900 mb-4">{{ setting('documents_title') }}</h2>
      <p class="text-[16px] text-slate-600 leading-relaxed">{{ setting('documents_description') }}</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5" id="docGrid">
      @foreach ($documents as $doc)
      <a href="{{ $doc->link }}" @if($doc->file || $doc->url) target="_blank" rel="noopener" @endif class="card-lift group flex gap-4 p-5 rounded-2xl bg-white border border-bone-100 shadow-soft" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
        <div class="shrink-0 w-12 h-12 rounded-xl bg-bone-50 border border-bone-100 grid place-items-center text-bone-700 group-hover:grad-bone group-hover:text-gold-300 group-hover:border-transparent transition">
          <i class="{{ $doc->icon }}"></i>
        </div>
        <div class="min-w-0">
          <div class="flex items-center gap-2 mb-1.5">
            <span class="text-[10.5px] font-extrabold tracking-wide px-2 py-0.5 rounded bg-gold-100 text-gold-700">{{ $doc->category }}</span>
            <span class="text-[10.5px] font-bold text-slate-400">{{ $doc->file_type }} · {{ $doc->file_size }}</span>
          </div>
          <p class="font-bold text-[15px] text-bone-900 leading-snug group-hover:text-bone-700 transition">{{ $doc->title }}</p>
          <p class="text-[13px] text-slate-500 mt-1 leading-relaxed">{{ $doc->description }}</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>
