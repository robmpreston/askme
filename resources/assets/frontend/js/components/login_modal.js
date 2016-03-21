(function(){
    'use strict';

    Vue.component('loginModal', {
        template: '#login-modal-template',
        props: ['show'],
        data: function () {
            return {
    	        title: '',
                body: '',
                login: true,
                firstName: '',
                lastName: '',
                email: '',
                password: ''
            };
        },
        methods: {
            close: function () {
                this.show = false;
                this.title = '';
                this.body = '';
            },
            toggle: function() {
                this.login = !this.login;
            },
            emailLogin: function () {
                this.$http.post('/api/login', { email: this.email, password: this.password }).then(function (response) {
                    if (!response.data.success) {

                    } else {
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                });
            },
            emailSignup: function () {
                this.$http.post('/api/user/store',
                { first_name: this.firstName, last_name: this.lastName, email: this.email, password: this.password }).then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                });
            }
        }
    });

})();
