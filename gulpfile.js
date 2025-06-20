import cssnano            from    'cssnano'
import {deleteAsync}      from    'del'
import gulp               from    'gulp'
import sourcemaps         from    'gulp-sourcemaps'
import postcss            from    'gulp-postcss'
import tailwind           from    '@tailwindcss/postcss'
import browserSync        from    'browser-sync'
import webpack            from    'webpack-stream'

const forProduction = process.env.NODE_ENV === 'production'

const baseUrl = 'http://k4-scaffold.test'

let postcssPlugins = [
  tailwind(),
]

if ( forProduction ) postcssPlugins.push( cssnano() )

export function clean () {
  return deleteAsync([
    './html/public/assets/css/*', 
    './html/public/assets/js/*', 
    './html/public/assets/maps/*'
  ])
}

function cleanImages () {
  return deleteAsync('./html/public/assets/images/*')
}

async function imageMin () {
  // import imagemin asynchronously because of a top level await error in node 22+
  // see https://github.com/sindresorhus/gulp-imagemin/issues/389#issuecomment-2530832191
  const imagemin = (await import('gulp-imagemin')).default
  return gulp.src(['./src/images/*', '!./src/images/*.svg'], { encoding: false })
    .pipe(imagemin())
    .pipe(gulp.dest('./html/public/assets/images'))
}


function imageCopy () {
  return gulp.src('./src/images/*.svg')
    .pipe(gulp.dest('./html/public/assets/images'))
}

export const images = gulp.series(cleanImages, imageMin, imageCopy)

function css () {
  return gulp.src([
    './src/css/main.css', 
    './src/css/print.css'
  ])
    .pipe(sourcemaps.init())
    .pipe(postcss(postcssPlugins))
    .pipe(sourcemaps.write('../maps'))
    .pipe(gulp.dest('./html/public/assets/css'))
    .pipe(browserSync.stream({once: true}))
}

function js () {
  const mode = forProduction ? 'production' : 'development'
  return gulp.src([
    './src/js/*'
  ])
    .pipe(webpack({
      mode: mode,
      module: {
        rules: [
          { 
            test: /\.js$/, 
            exclude: /node_modules/, 
            loader: "babel-loader" 
          },
          {
            test: /\.css$/,
            use: [
              'css-loader'
            ]
          }
        ],
      },
      entry: {
        main: './src/js/main.js',
      },
      output: {
        filename: '[name].js'
      }
    }))
    .pipe(gulp.dest('./html/public/assets/js'))
    .pipe(browserSync.stream())
}

function watch () {
  browserSync.init({
    proxy: {
      target: baseUrl,
      proxyReq: [
        function (req) {
          req.setHeader('Access-Control-Allow-Origin', '*')
        }
      ]
    },
    open: false
  })
  gulp.watch([
    './tailwind.config.js',
    './src/css/**/*',
    './html/site/**/*.php',
  ], {usePolling: true}, css)
  gulp.watch('./src/js/**/*', {usePolling: true}, js)
  gulp.watch([
    './html/site/**/*.yml',
  ], {usePolling: true}).on('change', browserSync.reload)
}

export const build = gulp.series(gulp.parallel(clean, images), gulp.parallel(css,js))
export const serve = gulp.series(gulp.parallel(css,js), watch)

export default serve
