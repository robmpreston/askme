Vue.component('loginModal', {
    template: '#login-modal-template',
    props: ['show'],
    data: function () {
        return {
	        title: '',
            body: '',
            login: false,
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
                    console.log('failed');
                } else {
                    $parent.user = response.data.user;
                }
            }, function (response) {
                console.log('failed');
            });
            this.close();
        }
    }
});
