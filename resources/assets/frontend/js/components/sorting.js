(function(){
    'use strict';

    Vue.component('sorting', {
        template: '#sorting-template',
        props: [ 'sortType' ],
        methods: {
            sort: function(type) {
                this.sortType = type;
            }
        }
    });

})();
