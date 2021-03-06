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
        './resources/assets/frontend/js/components/ask.js',
        './resources/assets/frontend/js/components/question.js',
        './resources/assets/frontend/js/components/answer.js',
        './resources/assets/frontend/js/components/feature.js',
        './resources/assets/frontend/js/components/modal.js',
        './resources/assets/frontend/js/components/login_modal.js',
        './resources/assets/frontend/js/components/edit_user_modal.js',
        './resources/assets/frontend/js/components/fbshare.js',
        './resources/assets/frontend/js/components/sorting.js',
        './resources/assets/frontend/js/components/tweet.js',
        './resources/assets/frontend/js/components/youtube.js',
        './resources/assets/frontend/js/app.js'
    ], 'public/frontend/js/app.js');
});
