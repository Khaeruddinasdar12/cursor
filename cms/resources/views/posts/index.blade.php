@extends('layouts.site')

@section('title', 'Pengumuman — '.setting('site_title'))

@section('content')
  @include('partials.page-hero', ['crumb' => 'Pengumuman', 'title' => setting('news_title')])

  <section class="py-16 lg:py-20 bg-bone-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      @if ($categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8">
          <a href="{{ route('posts.index') }}" class="text-[12.5px] font-bold px-4 py-1.5 rounded-full border {{ $activeCategory ? 'bg-white border-bone-100 text-bone-700 hover:border-gold-400' : 'bg-bone-700 border-bone-700 text-white' }} transition">Semua</a>
          @foreach ($categories as $category)
            <a href="{{ route('posts.index', ['kategori' => $category->slug]) }}" class="text-[12.5px] font-bold px-4 py-1.5 rounded-full border {{ $activeCategory?->is($category) ? 'bg-bone-700 border-bone-700 text-white' : 'bg-white border-bone-100 text-bone-700 hover:border-gold-400' }} transition">{{ $category->name }}</a>
          @endforeach
        </div>
      @endif

      <div class="space-y-4">
        @forelse ($posts as $post)
          @include('partials.post-card', ['post' => $post, 'delay' => 0])
        @empty
          <p class="text-center text-slate-500 py-16">Belum ada pengumuman.</p>
        @endforelse
      </div>

      <div class="mt-10">{{ $posts->links() }}</div>
    </div>
  </section>
@endsection
