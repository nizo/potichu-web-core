var gulp = require('gulp');
var bump = require('gulp-bump');
var replace = require('gulp-replace');
var fs = require('fs');
var semver = require('semver');
var git = require('gulp-git');


gulp.task('bump-version', function(){
	var pkg = JSON.parse(fs.readFileSync('./package.json', 'utf8'));
	var newVer = semver.inc(pkg.version, 'patch');

	gulp.src('./package.json')
		.pipe(bump({
			version: newVer
		}))
	.pipe(gulp.dest('./'));

	gulp.src('./style.css')
		.pipe(replace(/Version: .*/, 'Version: ' + newVer))
		.pipe(gulp.dest('./'));

	return gulp.src(['./package.json', './style.css'])
		.pipe(git.add());
});

gulp.task('pre-commit',  gulp.series('bump-version'));