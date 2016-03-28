(function(){
    'use strict';

    Vue.component('loginModal', {
        template: '#login-modal-template',
        props: ['show', 'userLocation'],
        data: function () {
            return {
    	        title: '',
                body: '',
                login: false,
                firstName: '',
                lastName: '',
                from: '',
                email: '',
                password: '',
                errorText: ''
            };
        },
        ready: function() {
            this.from = this.userLocation;
        },
        methods: {
            close: function () {
                this.show = false;
                this.login = false;
                this.clearFields();
            },
            toggle: function() {
                this.login = !this.login;
                this.clearFields();
            },
            emailLogin: function () {
                var self = this;
                this.$http.post('/api/login', { email: this.email, password: this.password }).then(function (response) {
                    if (!response.data.success) {
                        self.errorText = 'Email or password is incorrect.';
                    } else {
                        self.errorText = '';
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                });
            },
            emailSignup: function () {
                var self = this;
                this.$http.post('/api/user/store',
                { first_name: this.firstName, last_name: this.lastName, from: this.from, email: this.email, password: this.password })
                .then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.errorText = '';
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                    if (response.status == '422') {
                        self.errorText = '';
                        Object.keys(response.data).forEach(function (key) {
                           self.errorText += response.data[key][0] + '<br/>';
                        });
                    }
                });
            },
            clearFields: function() {
                this.firstName = '';
                this.lastName = '';
                this.email = '';
                this.password = '';
                this.errorText = '';
                this.title = '';
                this.body = '';
            }
        },
        computed: {
            loginValidated: function () {
                return (this.email != '' && this.password != '');
            },
            signupValidated: function() {
                return (this.firstName != '' && this.lastName != '' && this.from != '' && this.email != '' && this.password != '');
            }
        }
    });

})();
