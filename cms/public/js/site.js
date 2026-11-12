const SEARCH_INDEX = window.SEARCH_INDEX || [];

/* ═══════ Init AOS ═══════ */
AOS.init({ duration: 750, once: true, offset: 80, easing: 'ease-out-cubic' });

/* ═══════ Swiper jurnal ═══════ */
if (document.querySelector('.journalSwiper')) new Swiper('.journalSwiper', {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  autoplay: { delay: 4200, disableOnInteraction: false },
  pagination: { el: '.journalSwiper .swiper-pagination', clickable: true },
  breakpoints: { 640:{slidesPerView:1.6}, 768:{slidesPerView:2.2}, 1024:{slidesPerView:3, spaceBetween:24} }
});

/* ═══════ Navbar: shadow on scroll + tombol to-top ═══════ */
const nav = document.getElementById('nav'), toTop = document.getElementById('toTop');
window.addEventListener('scroll', () => {
  const y = window.scrollY;
  nav.classList.toggle('shadow-glow', y > 20);
  if (y > 500) { toTop.classList.remove('opacity-0','pointer-events-none'); }
  else { toTop.classList.add('opacity-0','pointer-events-none'); }
});
toTop.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));

/* ═══════ Mobile menu ═══════ */
const burger = document.getElementById('burger'), mobileMenu = document.getElementById('mobileMenu');
burger.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
  burger.innerHTML = mobileMenu.classList.contains('hidden')
    ? '<i class="fa-solid fa-bars text-lg"></i>' : '<i class="fa-solid fa-xmark text-lg"></i>';
});
mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  mobileMenu.classList.add('hidden');
  burger.innerHTML = '<i class="fa-solid fa-bars text-lg"></i>';
}));

/* ═══════ Pencarian ═══════ */
const searchModal = document.getElementById('searchModal'), searchInput = document.getElementById('searchInput'), searchResults = document.getElementById('searchResults');
function renderSearch(q='') {
  const s = q.trim().toLowerCase();
  const list = s ? SEARCH_INDEX.filter(x => x.t.toLowerCase().includes(s) || x.k.toLowerCase().includes(s)) : SEARCH_INDEX.slice(0,6);
  searchResults.innerHTML = list.length
    ? list.map(x => `<a href="${x.h}" data-close-link class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-bone-50 transition group">
        <i class="fa-solid fa-magnifying-glass text-bone-500 text-xs"></i>
        <span class="flex-1 font-semibold text-[14.5px] text-bone-900 group-hover:text-bone-700">${x.t}</span>
        <span class="text-[11px] font-bold px-2 py-0.5 rounded bg-gold-100 text-gold-700">${x.k}</span></a>`).join('')
    : `<p class="px-4 py-8 text-center text-[14px] text-slate-400">Tidak ada hasil untuk "${q}"</p>`;
}
function openSearch(){ searchModal.classList.remove('hidden'); renderSearch(); setTimeout(()=>searchInput.focus(),50); }
function closeSearch(){ searchModal.classList.add('hidden'); searchInput.value=''; }
document.getElementById('openSearch').addEventListener('click', openSearch);
searchModal.querySelectorAll('[data-close]').forEach(el => el.addEventListener('click', closeSearch));
searchInput.addEventListener('input', e => renderSearch(e.target.value));
searchResults.addEventListener('click', e => { if (e.target.closest('[data-close-link]')) closeSearch(); });
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeSearch();
  if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); openSearch(); }
});

/* ═══════ Counter statistik hero ═══════ */
const counters = document.querySelectorAll('.counter');
const obs = new IntersectionObserver(entries => {
  entries.forEach(en => {
    if (!en.isIntersecting) return;
    const el = en.target, target = +el.dataset.target;
    let cur = 0, step = Math.max(1, Math.ceil(target/45));
    const tick = () => { cur += step; if (cur >= target) { el.textContent = target; return; } el.textContent = cur; requestAnimationFrame(tick); };
    tick(); obs.unobserve(el);
  });
}, { threshold:.5 });
counters.forEach(c => obs.observe(c));
