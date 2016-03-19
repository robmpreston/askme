(function(){
    'use strict';

    Vue.component('feature', {
        template: '#feature-template',
        props: ['user'],
        data: function() {
        },
        methods: {
        },
        computed: {
            name: function() {
                return this.user.first_name + ' ' + this.user.last_name;
            }
        }
    });

})();
