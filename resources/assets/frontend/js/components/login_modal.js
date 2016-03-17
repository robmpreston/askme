Vue.component('loginModal', {
    template: '#login-modal-template',
    props: ['show'],
    data: function () {
        return {
	        title: '',
            body: ''
        };
    },
    methods: {
        close: function () {
            this.show = false;
            this.title = '';
            this.body = '';
        },
        savePost: function () {
            // Insert AJAX call here...
            this.close();
        }
    }
});
