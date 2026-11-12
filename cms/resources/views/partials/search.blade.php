<!-- Modal pencarian -->
<div id="searchModal" class="fixed inset-0 z-[60] hidden">
  <div class="absolute inset-0 bg-bone-950/60 backdrop-blur-sm" data-close></div>
  <div class="relative max-w-2xl mx-auto mt-24 px-4">
    <div class="bg-white rounded-3xl shadow-glow overflow-hidden">
      <div class="flex items-center gap-3 px-6 py-4 border-b border-bone-100">
        <i class="fa-solid fa-magnifying-glass text-bone-600"></i>
        <input id="searchInput" type="text" placeholder="{{ setting('search_placeholder') }}" class="flex-1 outline-none text-[15px] py-2 placeholder:text-slate-400" />
        <button data-close class="text-slate-400 hover:text-bone-800 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
      </div>
      <div class="p-3 max-h-[45vh] overflow-y-auto" id="searchResults"></div>
      <div class="px-6 py-3 bg-bone-50 text-[12.5px] text-slate-500 border-t border-bone-100">
        Tekan <kbd class="px-1.5 py-0.5 rounded bg-white border border-bone-200 font-semibold">Esc</kbd> untuk menutup
      </div>
    </div>
  </div>
</div>
