tailwind.config = {
  theme: {
    extend: {
      colors: {
        bone:    { 50:'#eefbf3', 100:'#d6f5e3', 200:'#b0e9cb', 300:'#7cd7ab', 400:'#45bd86', 500:'#1fa268', 600:'#128254', 700:'#0f6845', 800:'#0d5238', 900:'#0b432f', 950:'#04271c' },
        gold:    { 50:'#fdfbe9', 100:'#fbf6c6', 200:'#f8ea8f', 300:'#f4d94f', 400:'#efc51f', 500:'#dfa90d', 600:'#c08209', 700:'#995c0b', 800:'#7f4811', 900:'#6c3b14' }
      },
      fontFamily: {
        display: ['"Plus Jakarta Sans"','system-ui','sans-serif'],
        body:    ['"Plus Jakarta Sans"','system-ui','sans-serif'],
        arabic:  ['"Scheherazade New"','serif']
      },
      boxShadow: {
        soft: '0 10px 40px -12px rgba(4,39,28,.28)',
        glow: '0 0 0 1px rgba(18,130,84,.12), 0 18px 50px -18px rgba(4,39,28,.45)'
      },
      keyframes: {
        floaty:   { '0%,100%':{transform:'translateY(0)'}, '50%':{transform:'translateY(-14px)'} },
        marquee:  { '0%':{transform:'translateX(0)'}, '100%':{transform:'translateX(-50%)'} },
        shimmer:  { '0%':{backgroundPosition:'200% 0'}, '100%':{backgroundPosition:'-200% 0'} }
      },
      animation: {
        floaty:  'floaty 7s ease-in-out infinite',
        marquee: 'marquee 38s linear infinite',
        shimmer: 'shimmer 3.5s linear infinite'
      }
    }
  }
}
