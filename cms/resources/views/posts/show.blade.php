@extends('layouts.site')

@section('title', $post->title.' — '.setting('brand_name').' '.setting('brand_highlight'))
@section('description', \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?: $post->content), 160))

@section('content')
  @include('partials.page-hero', [
      'crumb' => 'Detail',
      'parent' => ['label' => 'Pengumuman', 'url' => route('posts.index')],
      'title' => $post->title,
      'meta' => new \Illuminate\Support\HtmlString(
          ($post->category ? '<span class="font-extrabold tracking-wide px-3 py-1 rounded-full bg-white/10 text-gold-300">'.e($post->category->name).'</span>' : '')
          .'<span class="text-bone-50/80"><i class="fa-regular fa-calendar mr-1.5 text-gold-300"></i>'.$post->display_date->format('d').' '.month_short($post->display_date->month).' '.$post->display_date->format('Y').'</span>'
      ),
  ])

  <section class="py-16 lg:py-20 bg-white pattern-light">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      @if ($post->image)
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post->image) }}" alt="{{ $post->title }}" class="w-full rounded-3xl shadow-soft mb-10 object-cover">
      @endif

      <article class="prose prose-slate max-w-none prose-headings:font-display prose-headings:text-bone-900 prose-a:text-bone-700">
        {!! \Illuminate\Support\Str::sanitizeHtml((string) $post->content) !!}
      </article>

      <div class="mt-12 pt-8 border-t border-bone-100">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-[14px] font-bold text-bone-700 hover:text-gold-600 transition"><i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke daftar pengumuman</a>
      </div>
    </div>
  </section>

  @if ($related->isNotEmpty())
    <section class="py-16 bg-bone-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display font-extrabold text-[24px] text-bone-900 mb-6">Pengumuman Lainnya</h2>
        <div class="space-y-4">
          @foreach ($related as $item)
            @include('partials.post-card', ['post' => $item, 'delay' => 0])
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endsection
