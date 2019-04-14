# laralix-jshint

## Install

```bash
npm install laralix-jshint --save-dev
touch .jshintrc
```

```js
// gulpfile.js
var elixir = require('laravel-elixir');

require('laralix-jshint');

elixir(function(mix) {
    'use strict';

    mix.jshint();
});
```

## Options

### Sources

Type: `String` or `Array`

Glob or array of globs to read. Using this will overwrite all defaults.

```javascript
// default
mix.jshint([
  'public/js/**/*.js',
  '!public/js/vendor/**/*.js'
]);
```

### JSHint options

Type: `Object`

_See [https://www.npmjs.com/package/gulp-jshint#options](https://www.npmjs.com/package/gulp-jshint#options)_
