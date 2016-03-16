var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('app.scss');
    mix.scripts([
        'components/question.js',
        'app.js'
    ]);
});
