<a href="{{ route('posts.show', $post) }}" class="card-lift flex gap-5 p-5 rounded-2xl bg-white border border-bone-100 shadow-soft group" data-aos="fade-up" data-aos-delay="{{ $delay ?? 0 }}">
  <div class="shrink-0 w-16 text-center">
    <div class="rounded-2xl grad-bone text-white py-2.5">
      <p class="font-extrabold text-xl leading-none">{{ $post->display_date->format('d') }}</p>
      <p class="text-[11px] font-semibold uppercase tracking-wide text-gold-300 mt-1">{{ month_short($post->display_date->month) }} {{ $post->display_date->format('Y') }}</p>
    </div>
  </div>
  <div class="min-w-0">
    @if ($post->category)<span class="text-[10.5px] font-extrabold tracking-wide px-2 py-0.5 rounded bg-bone-50 text-bone-700">{{ $post->category->name }}</span>@endif
    <p class="font-bold text-[16px] text-bone-900 mt-2 leading-snug group-hover:text-bone-700 transition">{{ $post->title }}</p>
    <p class="text-[13.5px] text-slate-500 mt-1.5 leading-relaxed">{{ $post->excerpt }}</p>
    <span class="inline-flex items-center gap-1.5 text-[13px] font-bold text-gold-600 mt-3">{{ setting('news_read_more_label') }} <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i></span>
  </div>
</a>
