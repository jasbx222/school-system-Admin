import preset from './vendor/filament/support/tailwind.config.preset'

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.php',
    './resources/**/*.vue',
    './vendor/filament/**/*.blade.php',
    './vendor/filament/**/*.js',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
