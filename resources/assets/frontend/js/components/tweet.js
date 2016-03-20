(function(){
    'use strict';

    Vue.component('tweet', {
        template: '#tweet-template',
        props: [ 'link', 'text' ]
    });

})();
