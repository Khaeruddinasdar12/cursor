<!-- ══════════════ TENTANG / VISI MISI ══════════════ -->
<section id="profil" class="relative py-20 lg:py-28 bg-white pattern-light">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-14 items-center">
    <div data-aos="fade-up">
      <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-3">{{ setting('profile_eyebrow') }}</p>
      <h2 class="font-display font-extrabold text-[32px] sm:text-[40px] leading-tight text-bone-900 mb-6 underline-gold inline-block">
        {{ setting('profile_title') }}
      </h2>
      <p class="text-[16px] leading-relaxed text-slate-600 mb-5">
        {{ setting('profile_paragraph1') }}
      </p>
      <p class="text-[16px] leading-relaxed text-slate-600 mb-8">
        {{ setting('profile_paragraph2') }}
      </p>

      <div class="space-y-4">
        <div class="flex gap-4 p-5 rounded-2xl bg-bone-50 border border-bone-100">
          <div class="shrink-0 w-11 h-11 rounded-xl bg-bone-700 grid place-items-center text-gold-300"><i class="fa-solid fa-eye"></i></div>
          <div>
            <p class="font-extrabold text-bone-900 mb-1">Visi</p>
            <p class="text-[14.5px] leading-relaxed text-slate-600">{{ setting('profile_vision') }}</p>
          </div>
        </div>
        <div class="flex gap-4 p-5 rounded-2xl bg-gold-50 border border-gold-200">
          <div class="shrink-0 w-11 h-11 rounded-xl bg-gold-400 grid place-items-center text-bone-950"><i class="fa-solid fa-bullseye"></i></div>
          <div>
            <p class="font-extrabold text-bone-900 mb-1">Misi</p>
            <p class="text-[14.5px] leading-relaxed text-slate-600">{{ setting('profile_mission') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Nilai / pilar -->
    <div class="grid sm:grid-cols-2 gap-5" data-aos="fade-up" data-aos-delay="120">
      @foreach ($pillars as $pillar)
      <div class="card-lift p-6 rounded-3xl bg-white border border-bone-100 shadow-soft{{ $loop->even ? ' sm:mt-8' : '' }}">
        <div class="arch-sm w-14 h-20 bg-gradient-to-b from-{{ $pillar->gradient_from }} to-{{ $pillar->gradient_to }} grid place-items-center mb-4">
          <i class="{{ $pillar->icon }} {{ str_starts_with($pillar->gradient_from, 'gold') ? 'text-bone-950' : 'text-gold-300' }} text-xl"></i>
        </div>
        <p class="font-extrabold text-bone-900 mb-2">{{ $pillar->title }}</p>
        <p class="text-[14px] leading-relaxed text-slate-500">{{ $pillar->description }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>
