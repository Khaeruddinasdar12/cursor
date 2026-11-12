<!-- ══════════════ PENGUMUMAN & AGENDA ══════════════ -->
<section id="pengumuman" class="py-20 lg:py-28 bg-bone-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-10">

    <!-- Pengumuman -->
    <div class="lg:col-span-7" data-aos="fade-up">
      <div class="flex items-end justify-between mb-8">
        <div>
          <p class="text-[13px] font-extrabold tracking-[.18em] text-gold-600 uppercase mb-2">{{ setting('news_eyebrow') }}</p>
          <h2 class="font-display font-extrabold text-[28px] sm:text-[34px] text-bone-900">{{ setting('news_title') }}</h2>
        </div>
        <a href="{{ route('posts.index') }}" class="text-[14px] font-bold text-bone-700 hover:text-gold-600 transition hidden sm:inline-flex items-center gap-2">
          {{ setting('news_all_label') }} <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
      </div>

      <div class="space-y-4" id="newsList">
        @foreach ($posts as $post)
          @include('partials.post-card', ['post' => $post, 'delay' => $loop->index * 60])
        @endforeach
      </div>
    </div>

    <!-- Agenda -->
    <div class="lg:col-span-5" data-aos="fade-up" data-aos-delay="120">
      <div class="bg-white rounded-3xl border border-bone-100 shadow-soft p-7 lg:sticky lg:top-28">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-11 h-11 rounded-2xl grad-bone grid place-items-center text-gold-300"><i class="fa-regular fa-calendar-check"></i></div>
          <div>
            <p class="font-extrabold text-bone-900 text-[17px]">{{ setting('agenda_title') }}</p>
            <p class="text-[12.5px] text-slate-500">{{ setting('agenda_subtitle') }}</p>
          </div>
        </div>

        <div class="space-y-3" id="agendaList">
          @foreach ($events as $event)
          <div class="flex gap-4 p-4 rounded-2xl bg-bone-50 border border-bone-100 hover:border-gold-300 transition">
            <div class="shrink-0 w-12 h-12 rounded-xl bg-white grid place-items-center border border-bone-100">
              <div class="text-center leading-none">
                <p class="font-extrabold text-bone-900 text-[15px]">{{ $event->event_date->format('d') }}</p>
                <p class="text-[9.5px] font-bold uppercase text-gold-600 mt-0.5">{{ month_short($event->event_date->month) }}</p>
              </div>
            </div>
            <div>
              <p class="font-bold text-[14.5px] text-bone-900 leading-snug">{{ $event->title }}</p>
              <p class="text-[12.5px] text-slate-500 mt-1"><i class="fa-regular fa-clock mr-1.5 text-gold-500"></i>{{ $event->place }}</p>
            </div>
          </div>
          @endforeach
        </div>

        @if ($officeHours->isNotEmpty())
        <div class="mt-6 pt-6 border-t border-bone-100">
          <p class="text-[12.5px] font-bold text-bone-900 mb-3">{{ setting('office_hours_title') }}</p>
          @foreach ($officeHours as $row)
          <div class="flex items-center justify-between text-[13.5px] text-slate-600 py-1.5">
            <span>{{ $row->days }}</span><span class="{{ $row->is_closed ? 'font-semibold text-slate-400' : 'font-bold text-bone-800' }}">{{ $row->hours }}</span>
          </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
