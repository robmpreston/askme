(function(){
    'use strict';

    Vue.component('feature', {
        template: '#feature-template',
        props: ['user', 'isAdmin'],
        data: function() {
            return {
                editing: false
            }
        },
        methods: {
            editProfile: function() {
                this.editing = true;
            },
            saveProfile: function() {

            },
            cancel: function() {
                this.editing = false;
            }
        },
        computed: {
            name: function() {
                return this.user.first_name + ' ' + this.user.last_name;
            }
        }
    });

})();
