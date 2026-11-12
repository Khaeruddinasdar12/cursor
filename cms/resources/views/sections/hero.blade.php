<!-- ══════════════ HERO ══════════════ -->
<section id="beranda" class="relative grad-bone pattern-islamic text-white overflow-hidden">
  <div class="absolute -top-24 -right-24 w-[520px] h-[520px] rounded-full bg-gold-400/20 blur-3xl"></div>
  <div class="absolute -bottom-40 -left-32 w-[560px] h-[560px] rounded-full bg-bone-400/20 blur-3xl"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-24 lg:pt-24 lg:pb-32 grid lg:grid-cols-12 gap-12 items-center">

    <div class="lg:col-span-7" data-aos="fade-right">
      <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur text-[12.5px] font-semibold tracking-wide mb-6">
        <span class="w-2 h-2 rounded-full bg-gold-300 animate-pulse"></span>
        {{ setting('hero_badge') }}
      </div>

      @if (setting('hero_arabic'))
        <p class="font-arabic text-3xl sm:text-4xl text-gold-200 mb-4" dir="rtl">{{ setting('hero_arabic') }}</p>
      @endif

      <h1 class="font-display font-extrabold text-[38px] sm:text-[48px] lg:text-[56px] leading-[1.06] tracking-tight mb-6">
        {{ setting('hero_title_line1') }}<br class="hidden sm:block">
        <span class="text-gold-grad">{{ setting('hero_title_highlight') }}</span>
      </h1>

      <p class="text-bone-50/85 text-[16.5px] leading-relaxed max-w-2xl mb-9">
        {{ setting('hero_description') }}
      </p>

      <div class="flex flex-wrap items-center gap-3.5 mb-10">
        <a href="{{ site_url(setting('hero_button1_url')) }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-gold-400 text-bone-950 font-bold text-[15px] shadow-soft hover:bg-gold-300 hover:-translate-y-0.5 transition">
          <i class="fa-solid fa-grip"></i> {{ setting('hero_button1_label') }}
        </a>
        <a href="{{ site_url(setting('hero_button2_url')) }}" class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-white/10 border border-white/25 backdrop-blur font-bold text-[15px] hover:bg-white/20 transition">
          <i class="fa-regular fa-bell text-gold-300"></i> {{ setting('hero_button2_label') }}
        </a>
      </div>

      @if ($stats->isNotEmpty())
      <div class="grid grid-cols-3 gap-5 max-w-xl pt-8 border-t border-white/15">
        @foreach ($stats as $stat)
        <div>
          <p class="font-extrabold text-3xl text-gold-300"><span class="counter" data-target="{{ $stat->value }}">0</span>{{ $stat->suffix }}</p>
          <p class="text-[12.5px] text-bone-50/70 font-medium mt-1">{{ $stat->label }}</p>
        </div>
        @endforeach
      </div>
      @endif
    </div>

    <!-- Kartu layanan cepat -->
    <div class="lg:col-span-5" data-aos="fade-left" data-aos-delay="150">
      <div class="relative">
        <div class="absolute inset-0 translate-x-4 translate-y-4 rounded-[34px] border-2 border-gold-400/40"></div>
        <div class="relative glass rounded-[30px] p-7 shadow-glow animate-floaty">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-11 h-11 rounded-2xl bg-bone-700 grid place-items-center text-gold-300"><i class="fa-solid fa-bolt"></i></div>
            <div>
              <p class="font-extrabold text-bone-900 text-[17px]">{{ setting('hero_card_title') }}</p>
              <p class="text-[12.5px] text-slate-500">{{ setting('hero_card_subtitle') }}</p>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            @foreach ($heroLinks as $link)
            <a href="{{ site_url($link->url) }}" class="group p-4 rounded-2xl bg-white border border-bone-100 hover:border-gold-400 hover:shadow-soft transition">
              <i class="{{ $link->icon }} text-xl text-bone-600 group-hover:text-gold-600 transition"></i>
              <p class="mt-2.5 text-[13.5px] font-bold text-bone-900 leading-snug">{{ $link->title }}</p>
            </a>
            @endforeach
          </div>
          <div class="mt-5 p-4 rounded-2xl bg-bone-900 text-white flex items-start gap-3">
            <i class="fa-solid fa-circle-info text-gold-300 mt-0.5"></i>
            <p class="text-[12.5px] leading-relaxed text-bone-50/80">
              {{ setting('hero_card_note') }}
              <span class="font-bold text-gold-300">{{ setting('hero_card_note_highlight') }}</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Wave pemisah -->
  <svg class="absolute bottom-0 left-0 w-full text-white" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
    <path fill="currentColor" d="M0,64 C240,110 480,10 720,34 C960,58 1200,104 1440,60 L1440,90 L0,90 Z"></path>
  </svg>
</section>

@if ($announcements->isNotEmpty())
<!-- ══════════════ MARQUEE PENGUMUMAN ══════════════ -->
<div class="bg-white border-b border-bone-100">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4 py-3.5">
    <span class="shrink-0 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gold-400 text-bone-950 text-[12.5px] font-extrabold">
      <i class="fa-solid fa-bullhorn"></i> {{ setting('ticker_label') }}
    </span>
    <div class="relative overflow-hidden flex-1">
      <div class="flex gap-10 whitespace-nowrap animate-marquee">
        @foreach ([0, 1] as $copy)
          @foreach ($announcements as $announcement)
            <span class="text-[13.5px] font-medium text-slate-600"><i class="fa-solid fa-circle text-[5px] text-gold-500 align-middle mr-2"></i>@if($announcement->url)<a href="{{ site_url($announcement->url) }}" class="hover:text-bone-700 transition">{{ $announcement->text }}</a>@else{{ $announcement->text }}@endif</span>
          @endforeach
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif
