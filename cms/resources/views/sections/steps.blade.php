<!-- ══════════════ ALUR LAYANAN ══════════════ -->
<section class="py-20 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-12 gap-12 items-start">
      <div class="lg:col-span-4 lg:sticky lg:top-28" data-aos="fade-up">
        <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-3">{{ setting('steps_eyebrow') }}</p>
        <h2 class="font-display font-extrabold text-[32px] sm:text-[38px] leading-tight text-bone-900 mb-5">
          {{ setting('steps_title') }}
        </h2>
        <p class="text-[16px] leading-relaxed text-slate-600 mb-7">
          {{ setting('steps_description') }}
        </p>
        <a href="{{ site_url(setting('steps_button_url')) }}" class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-full grad-bone text-white font-bold text-[15px] shadow-soft hover:-translate-y-0.5 transition">
          <i class="fa-solid fa-rocket text-gold-300"></i> {{ setting('steps_button_label') }}
        </a>
      </div>

      <div class="lg:col-span-8 grid sm:grid-cols-2 gap-5">
        @foreach ($steps as $step)
        <div class="relative p-6 rounded-3xl bg-bone-50 border border-bone-100 card-lift{{ $loop->even ? ' sm:mt-8' : '' }}" data-aos="fade-up"@if($loop->index) data-aos-delay="{{ $loop->index * 70 }}"@endif>
          <span class="absolute -top-4 left-6 w-9 h-9 rounded-xl {{ $loop->even ? 'bg-gold-400 text-bone-950' : 'grad-bone text-gold-300' }} grid place-items-center font-extrabold text-sm shadow-soft">{{ $loop->iteration }}</span>
          <h3 class="font-extrabold text-bone-900 mt-3 mb-2">{{ $step->title }}</h3>
          <p class="text-[14px] leading-relaxed text-slate-600">{{ $step->description }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
