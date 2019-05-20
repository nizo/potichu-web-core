var gulp = require('gulp');
var bump = require('gulp-bump');
var replace = require('gulp-replace');
var fs = require('fs');
var semver = require('semver');

gulp.task('default', function(){
	var pkg = JSON.parse(fs.readFileSync('./package.json', 'utf8'));
	var newVer = semver.inc(pkg.version, 'patch');

	gulp.src('./package.json')
		.pipe(bump({
			version: newVer
		}))
	.pipe(gulp.dest('./'));

	return gulp.src(['style.css'])
		.pipe(replace(/Version: .*/, 'Version: ' + newVer))
		.pipe(gulp.dest('./'));
});