const cssnano = require('cssnano')({
  preset: ['default', {
    discardComments: {
      removeAll: true,
    },
  }]
});

module.exports = {
  plugins: [
    require('tailwindcss')('./tailwind.config.js'),
    require('autoprefixer')({ grid: true, overrideBrowserslist: ['last 2 versions'] }),
    ...(process.env.NODE_ENV === "production" ? [cssnano] : []),
  ]
}
