Vue.component('loginModal', {
    template: '#login-modal-template',
    props: ['show'],
    data: function () {
        return {
	        title: '',
            body: '',
            login: false
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
        savePost: function () {
            // Insert AJAX call here...
            this.close();
        }
    }
});
