// tailwind.config.js

const screens = require('./mediaqueries.json');

module.exports = {
  content: [
    './config/custom/*.php',
    './modules/cchelpersmodule/src/services/Helpers.php',
    './templates/**/*.html',
    './templates/**/*.twig',
    './src/sass/.classes',
    './src/js/**/*.js'
  ],
  theme: {

    screens: screens,

    container: false,

    colors: {

      // Wireframe Colours
      'wf-lightest': '#EEF1FF',
      'wf-light': '#D8DFFF',
      'wf-med'  : '#9DAAFF',
      'wf-dark': '#7D8FFF',
      'wf-darkest': '#4660FF',

      // Base Colours
      'black': '#000',
      'white': '#FFF',
      'transparent': 'transparent',

      // UI
      'type': '#3a3a3a',
      'rule': '#ddd',
      'rule-dark': '#444',
      'limit': '#F8F9FF',
      'bar': '#f3f3f3',
      'control': '#6F6F6F',
      'overlay': 'rgba(0, 0, 0, .40)',
      'video': 'rgba(15, 25, 60, .25)',
      'video-overlay': 'rgba(15, 25, 60, .65)',
      'overlay-light': 'rgba(37, 39, 42, 0.1)',

      // Brand Colours
      'brand': "#3A5088",
      'brand-dark': '#304677',
      'accent': '#fbdc8e',
      'dark': '#383b50',
      'darker': '#2a2d3f',

      'basalt': '#25272A',
      'salt': '#F0EFE1',
      'sand': '#EAE2D2',
      'terracotta': '#EBC09F',
      'kilohana': '#E19480',
      'bark': '#E0A769',
      'ryegrass': '#BCB385',
      'hanana': '#A4A887',
      'palenka': '#6B98AD',
      'off-white': '#FFFDF2',
      'mana': '#E2A276',
      'eleu': '#7E9C91',
      'brand-red': '#c64d2f',

      // Notice Colours
      'success': '#238823',
      'error': '#D2222D',
      'warning': '#FFBF00',
    },

    stroke: theme => ({
      'white': theme('colors.white'),
      'black': theme('colors.black'),
      'none': theme('colors.transparent'),
      'rule': theme('colors.rule'),
      'brand': theme('colors.brand'),
    }),

    fill: theme => ({
      'white': theme('colors.white'),
      'black': theme('colors.black'),
      'none': theme('colors.transparent'),
      'rule': theme('colors.rule'),
      'bar': theme('colors.bar'),
      'brand': theme('colors.brand'),
      'brand-dark': theme('colors.brand-dark'),
      'dark': theme('colors.dark'),
      'darker': theme('colors.darker'),
      'basalt': theme('colors.basalt'),
      'terracotta': theme('colors.terracotta'),
      'salt': theme('colors.salt'),
      'sand': theme('colors.sand'),
      'off-white': theme('colors.off-white'),
      'error': theme('colors.error'),
      'success': theme('colors.success'),

    }),

    spacing: {
      'none': '0',

      // Base sizes
      'p1': '0.0625rem',
      'p2': '0.125rem',
      'p3': '0.1875rem',
      'p4': '0.25rem',
      'p5': '0.3125rem',
      'p6': '0.375rem',
      'p8': '0.5rem',
      'p10': '0.625rem',
      'p12': '0.75rem',
      'p14': '0.875rem',
      'p16': '1rem',
      'p20': '1.25rem',
      'p24': '1.5rem',
      'p30': '1.875rem',
      'p32': '2rem',
      'p40': '2.5rem',
      'p48': '3rem',
      'p50': '3.125rem',
      'p64': '4rem',
      'p72': '4.5rem',
      'p80': '5rem',
      'p100': '6.25rem',
      'p128': '8rem',
      'p160': '10rem',
      'p192': '12rem',
      'p200': '12.5rem',
      'p230': '14.375rem',
      'p256': '16rem',
      'p260': '16.25rem',
      'p300': '18.75rem',
      'p340': '21.25rem',
      'p370': '23.125rem',
      'p450': '28.125rem',
      'p560': '35rem',
      'p1000': '62.5rem',

      // Custom Sizes
      'img': '42rem',
      'logo': '4rem',
      'p1300': '81.25rem',
      'headerSm': '8.5rem',
      'headerLg': '11.75rem',
      'brush-top': '8.75rem',
      'filters': 'calc(100vh - 15rem)',

      // Ratios
      // These values are useful for setting percentage-based ratios
      'ratio-video': '56.25%',
      'ratio-img-card': '120%',


    },

    fontFamily: {
      title: ['beausite_classic', 'Arial', 'sans-serif'],
      sans: ['beausite_classic', 'Arial', 'sans-serif'],
      display: ['boujond', 'Brush Script MT', 'sans-serif' ],
      serif: ['Merriweather', 'Times', 'Times New Roman', 'serif'],
      mono: ['Consolas', '"Courier New"', 'monospace'],
    },

    fontSize: {
      'p70': '4.375rem', // 70px
      'p60': '3.75rem',  // 60px
      'p50': '3.125rem', // 50px
      'h1':  '3rem',     // 48px
      'p40': '2.5rem',   // 40px
      'h2':  '2.25rem',  // 36px
      'p35': '2.1875rem',// 35px
      'h3':  '1.875rem', // 30px
      'p26': '1.625rem', // 26px
      'h4':  '1.5rem',   // 24px
      'p22': '1.375rem', // 22px
      'p20': '1.25rem',
      'h5':  '1.25rem',  // 20px
      'lg':  '1.125rem', // 18px
      'bd':  '1rem',     // 16px
      'sm':  '.875rem',  // 14px
      'btn': '.75rem',   // 12px
      'xs':  '.75rem',
      'tn':  '.6875rem', // 11px
      'display': '140%',
    },

    lineHeight: {
      'h': '1.25em',
      'xl': '2em',
      'lg': '1.6em',
      'e1/4': '1.4em',
      'md': '1.2em',
      'e1': '1em',
      'tn': '1.125em',
      'trim': '0.6em',
    },

    extend: {
      zIndex: {
        '1': '1',
        '2': '2',
        '60': '60',
        '70': '70',
        '100': '100',
      },
      inset: {
        '0' : '0',
        'bullet': 'calc(100% + .5rem)',
      },
      backgroundImage: {
        'seamless-gradient': 'linear-gradient(0deg, rgba(240,239,225,1) 26%, rgba(240,239,225,0) 64%)',
      },
      borderRadius: {
        'input': '3px',
        'p10': '10px',
        'p20': '20px',
      },
      boxShadow: {
        'card-sm': '0px 0px 50px 5px rgba(0, 0, 0, 0.05)',
        'card-lg': '0px 70px 50px rgba(0, 0, 0, 0.05)',
        'card-lg-hover': '0px 70px 60px rgba(0, 0, 0, 0.08)',
        'btn-lg': '0px 30px 30px rgba(0, 0, 0, 0.2)',
        'notice': '0px 4px 11px 0px rgba(0,0,0, 0.25)',
      },
      maxWidth: {
        'p120': '7.5rem',
        'p200': '12.5rem',
        'p320': '20rem',
        'p420': '26.25rem',
        'p448': '28rem',
        'p512': '32rem',
        'p768': '48rem',
        'p960': '60rem',
        'p1024': '64rem',
        'p1280': '80rem',
        'p1440': '90rem',
        'limit': '120rem',
        '1/2': '50%',
        '1/3': '33.33%',
        '1/4': '25%',
      },
      minWidth: {
        'p60': '3.75rem',
        'p80': '5rem',
      },
      minHeight: {
        'p60': '3.75rem',
        'p80': '5rem',
        'p288': '288px',
      },
      transition: {
        'width': 'width',
        'height': 'height',
        'visible': 'opacity, visibility',
      },
      animation: {
        'timer': 'timer 3s ease-out 1',
      },
      keyframes: {
        timer: {
          '0%': { width: '0' },
          '100%': { width: '100%' }
        },
      },
      dropShadow: {
        'close': '8px 52px 4px rgba(0, 0, 0, 0.15)',
        'mid': '10px 140px 14px rgba(0, 0, 0, 0.1)',
        'far': '10px 300px 24px rgba(0, 0, 0, 0.075)',
      },
      blur:  {
        '1': '1px',
        '1-1/2': '1.5px',
        '4': '4px',
      }
    },
  },
  variants: {
    extend: {
      borderColor: ['group-hover', 'group-focus'],
      backgroundColor: ['group-hover', 'group-focus'],
      textColor: ['group-focus'],
      fill: ['group-hover', 'group-focus'],
      translate: ['group-hover', 'group-focus'],
      inset: ['group-hover', 'group-focus'],
      opacity: ['group-focus'],
      accessibility: ['responsive'],
    }
  },
  plugins: [],
}