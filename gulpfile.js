var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('./resources/assets/backend/sass/app.scss', 'public/backend/css/app.css')
    .sass('./resources/assets/frontend/sass/app.scss', 'public/frontend/css/app.css');
    
    mix.scripts([
        './resources/assets/backend/js/components/question.js',
        './resources/assets/backend/js/components/answer.js',
        './resources/assets/backend/js/components/feature.js',
        './resources/assets/backend/js/app.js'
    ], 'public/backend/js/app.js')
    .scripts([
        './resources/assets/frontend/js/components/question.js',
        './resources/assets/frontend/js/components/answer.js',
        './resources/assets/frontend/js/components/feature.js',
        './resources/assets/frontend/js/app.js'
    ], 'public/frontend/js/app.js');
});
