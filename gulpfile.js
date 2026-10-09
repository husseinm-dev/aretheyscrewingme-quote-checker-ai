const gulp = require("gulp");
const cleanCSS = require("gulp-clean-css");
const terser = require("gulp-terser");
const imagemin = require("gulp-imagemin");
const gulpif = require("gulp-if");
const newer = require("gulp-newer");
const del = require("del");
const fs = require("fs");

// Paths
const paths = {
  css: {
    src: "public/assets/css/*.css",
    dest: "hostinger/public_html/assets/css",
  },
  js: {
    src: "public/assets/js/**/*.js",
    dest: "hostinger/public_html/assets/js",
  },
  images: {
    src: "public/assets/img/**/*",
    dest: "hostinger/public_html/assets/img",
  },
  video: {
    src: "public/assets/video/**/*",
    dest: "hostinger/public_html/assets/video",
  },
  php: {
    public: "public/**/*.php",
    publicDest: "hostinger/public_html",
    config: "config/**/*",
    configDest: "hostinger/config",
    src: "src/**/*",
    srcDest: "hostinger/src",
    sql: "sql/**/*",
    sqlDest: "hostinger/sql",
  },
  htaccess: {
    src: "public/.htaccess",
    dest: "hostinger/public_html",
  },
  robots: {
    src: ["public/robots.txt", "public/sitemap.xml"],
    dest: "hostinger/public_html",
  },
  composer: {
    src: ["composer.json", "composer.lock"],
    dest: "hostinger",
  },
};

// Clean build folder
function clean() {
  return del(["hostinger/**", "!hostinger"]);
}

// Minify CSS
function css() {
  return gulp
    .src(paths.css.src)
    .pipe(newer(paths.css.dest))
    .pipe(cleanCSS({ compatibility: "ie9", level: 2 }))
    .pipe(gulp.dest(paths.css.dest));
}

// Minify JavaScript
function js() {
  return gulp
    .src(paths.js.src)
    .pipe(newer(paths.js.dest))
    .pipe(
      terser({
        compress: {
          drop_console: true,
          drop_debugger: true,
        },
        mangle: true,
      }),
    )
    .pipe(gulp.dest(paths.js.dest));
}

// Optimize images
function images() {
  return gulp
    .src(paths.images.src)
    .pipe(newer(paths.images.dest))
    .pipe(
      imagemin([
        imagemin.mozjpeg({ quality: 85, progressive: true }),
        imagemin.optipng({ optimizationLevel: 5 }),
        imagemin.svgo({
          plugins: [{ removeViewBox: false }, { cleanupIDs: false }],
        }),
      ]),
    )
    .pipe(gulp.dest(paths.images.dest));
}

// Copy video files
function video() {
  return gulp
    .src(paths.video.src)
    .pipe(newer(paths.video.dest))
    .pipe(gulp.dest(paths.video.dest));
}

// Copy PHP files from public folder (maintaining structure)
function phpPublic() {
  return gulp
    .src(paths.php.public, { base: "public" })
    .pipe(gulp.dest(paths.php.publicDest));
}

// Copy config files
function phpConfig() {
  return gulp.src(paths.php.config).pipe(gulp.dest(paths.php.configDest));
}

// Copy src files
function phpSrc() {
  return gulp.src(paths.php.src).pipe(gulp.dest(paths.php.srcDest));
}

// Copy SQL files
function sqlFiles() {
  return gulp.src(paths.php.sql).pipe(gulp.dest(paths.php.sqlDest));
}

// Copy .htaccess
function htaccess() {
  return gulp.src(paths.htaccess.src).pipe(gulp.dest(paths.htaccess.dest));
}

// Copy robots.txt and sitemap.xml
function robots() {
  return gulp.src(paths.robots.src).pipe(gulp.dest(paths.robots.dest));
}

// Copy composer files
function composer() {
  return gulp.src(paths.composer.src).pipe(gulp.dest(paths.composer.dest));
}

// Create storage directory structure
function storage(done) {
  return gulp
    .src("storage/uploads/.gitkeep", { allowEmpty: true })
    .pipe(gulp.dest("hostinger/storage/uploads"))
    .on("end", done);
}

// Update CSS version in header.php with timestamp
function updateCSSVersion() {
  const timestamp = Date.now();
  const publicHeader = "public/partials/header.php";
  const hostingerHeader = "hostinger/public_html/partials/header.php";

  // Update public header first
  if (fs.existsSync(publicHeader)) {
    let content = fs.readFileSync(publicHeader, "utf8");
    content = content.replace(
      /\/assets\/css\/app\.css\?v=[^"]+/,
      `/assets/css/app.css?v=${timestamp}`,
    );
    fs.writeFileSync(publicHeader, content);
  }

  // Update hostinger header if it exists
  if (fs.existsSync(hostingerHeader)) {
    let content = fs.readFileSync(hostingerHeader, "utf8");
    content = content.replace(
      /\/assets\/css\/app\.css\?v=[^"]+/,
      `/assets/css/app.css?v=${timestamp}`,
    );
    fs.writeFileSync(hostingerHeader, content);
  }

  return Promise.resolve();
}

// Watch files for changes
function watchFiles() {
  gulp.watch(paths.css.src, css);
  gulp.watch(paths.js.src, js);
  gulp.watch(paths.images.src, images);
  gulp.watch(paths.video.src, video);
  gulp.watch(paths.php.public, phpPublic);
  gulp.watch(paths.php.config, phpConfig);
  gulp.watch(paths.php.src, phpSrc);
}

// Complex tasks
const build = gulp.series(
  clean,
  gulp.parallel(
    css,
    js,
    images,
    video,
    phpPublic,
    phpConfig,
    phpSrc,
    sqlFiles,
    htaccess,
    robots,
    composer,
    storage,
  ),
);

const watch = gulp.series(build, watchFiles);

// Deploy task - optimized build with version update
const deploy = gulp.series(clean, build, updateCSSVersion);

// Export tasks
exports.clean = clean;
exports.css = css;
exports.js = js;
exports.images = images;
exports.video = video;
exports.php = gulp.parallel(phpPublic, phpConfig, phpSrc);
exports.updateVersion = updateCSSVersion;
exports.build = build;
exports.watch = watch;
exports.deploy = deploy;
exports.default = build;
