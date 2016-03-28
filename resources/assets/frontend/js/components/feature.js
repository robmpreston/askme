(function(){
    'use strict';

    Vue.component('feature', {
        template: '#feature-template',
        props: ['user', 'isAdmin', 'topic'],
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
                this.$http.post('/api/user/profile/update',
                {
                    first_name: this.user.first_name,
                    last_name: this.user.last_name,
                    i_am_a: this.user.profile.i_am_a,
                    from: this.user.from,
                    description: this.user.profile.description
                }).then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.$dispatch('user-updated', response.data.data.user);
                    }
                }, function (response) {
                    console.log('failed');
                });
                this.editing = false;
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
