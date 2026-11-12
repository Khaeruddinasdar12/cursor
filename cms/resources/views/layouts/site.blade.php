<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title', setting('site_title'))</title>
<meta name="description" content="@yield('description', setting('meta_description'))" />
@if (setting('favicon'))
<link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(setting('favicon')) }}" />
@else
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='22' fill='%2304612f'/%3E%3Cpath d='M50 18 L74 40 L74 74 L26 74 L26 40 Z' fill='none' stroke='%23eab308' stroke-width='6'/%3E%3C/svg%3E" />
@endif

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script src="{{ asset('js/tailwind-config.js') }}"></script>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<!-- AOS scroll animations -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
<!-- Swiper (carousel) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<link rel="stylesheet" href="{{ asset('css/site.css') }}">
@stack('head')
</head>

<body class="bg-white text-slate-700 antialiased overflow-x-hidden">

@include('partials.topbar')
@include('partials.header')

@yield('content')

@include('partials.footer')

<!-- Tombol kembali ke atas -->
<button id="toTop" class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full grad-bone text-gold-300 shadow-glow grid place-items-center opacity-0 pointer-events-none transition" aria-label="Kembali ke atas">
  <i class="fa-solid fa-chevron-up"></i>
</button>

@include('partials.search')

<!-- Libraries -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>window.SEARCH_INDEX = @json($searchIndex ?? []);</script>
<script src="{{ asset('js/site.js') }}"></script>
</body>
</html>
