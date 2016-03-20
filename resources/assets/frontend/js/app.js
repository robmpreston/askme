(function(){
    'use strict';

    var vm = new Vue({
        el: '#app',
        data: {
            showLoginModal: false,
            recipient: recipient,
            questions: questions,
            loggedIn: loggedIn,
            user: user,
            isAdmin: isAdmin,
            baseUrl: baseUrl,
            profileFormUpload:new FormData(),
        },
        methods: {
            logout: function () {
                this.$http.get('/logout').then(function(response) {
                    this.loggedIn = false;
                    this.user = null;
                });
            },
            bindFile: function() {
                this.profileFormUpload.append('file', this.$els.fileinput.files[0]);
                this.$http.post('/api/user/picture', this.profileFormUpload, function(data){
                    this.user = data.data;
                }).error(function (data, status, request) {
                    //error handling here
                });
            }
        },
        events: {
            'user-updated': function (user) {
                this.user = user;
                this.loggedIn = true;
            },
            'questions-updated': function(questions) {
                this.questions = questions;
            }
        }
    });

})();
