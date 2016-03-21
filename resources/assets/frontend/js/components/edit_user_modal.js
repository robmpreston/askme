(function(){
    'use strict';

    Vue.component('editUserModal', {
        template: '#edit-user-modal-template',
        props: ['show', 'user'],
        data: function () {
            return {
    	        title: '',
                body: '',
                password: '',
                validationError: ''
            };
        },
        methods: {
            close: function () {
                this.show = false;
                this.title = '';
                this.body = '';
            },
            updateUser: function() {
                this.$http.post('/api/user/update',
                { first_name: this.user.first_name, last_name: this.user.last_name, email: this.user.email, password: this.password })
                .then(function (response) {
                    if (response.data.success) {
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                    console.log('failed');
                });
            }
        },
        computed: {
            validated: function() {
                return (this.user.first_name != '' && this.user.last_name != ''
                    && this.user.email != '');
            }
        }
    });

})();
