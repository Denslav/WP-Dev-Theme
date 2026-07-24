let gulp = require('gulp');
let gulpif = require('gulp-if');
let browserSyncInstance = require('browser-sync').create();
let sass = require('gulp-sass')(require('sass'));
let prefixer = require('gulp-autoprefixer');
let sourcemaps = require('gulp-sourcemaps');
let webpack = require('webpack-stream');
let webpackCore = require('webpack');
let path = require('path');
let glob = require('glob');
let postcss = require('gulp-postcss');
let pxtorem = require('postcss-pxtorem');
let fs = require('fs');

let themeName = process.env.WP_THEME_NAME || 'dev-main';
let host = process.env.WP_PROXY || 'http://nbco.loc';
let mode = process.env.NODE_ENV === 'development' ? 'development' : 'production';

function cleanDist(done) {
    fs.rmSync('dist', { recursive: true, force: true });
    done();
}

function browserSync(done) {
    browserSyncInstance.init({
        proxy: host,
        open: false,
        notify: false,
        serveStatic: [
            {
                route: '/wp-content/themes/' + themeName + '/dist/css',
                dir: 'dist/css'
            },
            {
                route: '/wp-content/themes/' + themeName + '/dist/js',
                dir: 'dist/js'
            }
        ],
        files: ['dist/css/**/*.css', 'dist/js/**/*.js']
    });
    done();
}

function startWatch(done) {
    gulp.watch(['**/*.php']).on('change', browserSyncInstance.reload);
    gulp.watch('src/js/**/*.js', gulp.series(buildScripts, browserSyncInstance.reload));
    gulp.watch('theme.json', gulp.series(jsonToScss, buildStyles));
    gulp.watch('src/scss/**/*.scss', buildStyles);
    gulp.watch('src/fonts/**/*', copyFonts);
    done();
}

function buildStyles() {
    return gulp.src([
        'src/scss/global.scss',
        'src/scss/fonts.scss',
        'src/scss/header.scss',
        'src/scss/footer.scss',
        'src/scss/admin-styles.scss',
        'src/scss/pages/**/*.scss',
        'src/scss/blocks/**/*.scss',
        'src/scss/libs/**/*.scss',
        '!src/scss/**/_*.scss'
    ], { base: 'src/scss' })
        .pipe(gulpif(mode === 'development', sourcemaps.init()))
        .pipe(sass({
            outputStyle: 'compressed',
            includePaths: ['node_modules']
        }).on('error', sass.logError))
        .pipe(postcss([
            pxtorem({
                rootValue: 16,
                unitPrecision: 5,
                propList: ['*'],
                replace: true,
                mediaQuery: true,
                minPixelValue: 1
            })
        ]))
        .pipe(gulpif(mode === 'production', prefixer('last 4 versions')))
        .pipe(gulpif(mode === 'development', sourcemaps.write('.')))
        .pipe(gulp.dest('dist/css/'))
        .pipe(browserSyncInstance.stream());
}

function copyFonts() {
    return gulp.src('src/fonts/**/*', { base: 'src/fonts', allowEmpty: true })
        .pipe(gulp.dest('dist/fonts'));
}

function buildScripts() {
    let entries = {};

    glob.sync('./src/js/**/*.js').forEach(function (filePath) {
        let relativePath = path.relative('./src/js', filePath);
        let entryName = relativePath.replace(/\.js$/, '');
        entries[entryName] = filePath;
    });

    let webpackConfig = {
        mode: mode,
        devtool: mode === 'development' ? 'source-map' : false,
        entry: entries,
        output: {
            filename: '[name].min.js'
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        }
    };

    return webpack(webpackConfig, webpackCore)
        .pipe(gulp.dest('dist/js'))
        .pipe(browserSyncInstance.stream());
}

function jsonToScss(done) {
    let theme = JSON.parse(fs.readFileSync('theme.json', 'utf8'));
    let scssContent = '';

    scssContent += `$wp--preset--container--content-size: ${theme.settings.layout.contentSize};\n`;
    scssContent += `$wp--preset--container--wide-size: ${theme.settings.layout.wideSize};\n`;

    theme.settings.color.palette.forEach(function (color) {
        scssContent += `$wp--preset--color--${color.slug}: ${color.color};\n`;
    });

    theme.settings.color.gradients.forEach(function (gradient) {
        scssContent += `$wp--preset--gradient--${gradient.slug}: ${gradient.gradient};\n`;
    });

    theme.settings.typography.fontSizes.forEach(function (fontSize) {
        scssContent += `$wp--preset--font-size--${fontSize.slug}: ${fontSize.size};\n`;
    });

    theme.settings.typography.fontFamilies.forEach(function (fontFamily) {
        scssContent += `$wp--preset--font-family--${fontFamily.slug}: ${fontFamily.fontFamily};\n`;
    });

    fs.writeFileSync('src/scss/_gutenberg-variables.scss', scssContent);
    done();
}

let compile = gulp.parallel(buildScripts, buildStyles, copyFonts);
let build = gulp.series(cleanDist, jsonToScss, compile);

exports.clean = cleanDist;
exports.build_styles = buildStyles;
exports.build_json = jsonToScss;
exports.build_js = buildScripts;
exports.copy_fonts = copyFonts;
exports.build = build;
exports.default = gulp.series(build, gulp.parallel(browserSync, startWatch));
