(function(){
    'use strict';

    var vm = new Vue({
        el: '#app',
        data: {
            showLoginModal: false,
            showEditModal: false,
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
                this.profileFormUpload.append('file', this.$els.fileInput.files[0]);
                this.$http.post('/api/user/picture', this.profileFormUpload, function(data){
                    this.user = data.data;
                    if (this.user.id == this.recipient.id) {
                        this.recipient.picture = this.user.picture;
                    }
                }).error(function (data, status, request) {
                    //error handling here
                });
            },
            openFile: function() {
                this.$els.fileInput.click();
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
