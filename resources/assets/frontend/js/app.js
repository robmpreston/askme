(function(){
    'use strict';

    var vm = new Vue({
        el: '#app',
        data: {
            showLoginModal: false,
            showEditModal: false,
            recipient: recipient,
            questions: [],
            loggedIn: loggedIn,
            featuredQuestion: featuredQuestion,
            featuredShowing: true,
            sortType: 'trending',
            user: user,
            isAdmin: isAdmin,
            baseUrl: baseUrl,
            topic: topic,
            userLocation: userLocation,
            profileFormUpload:new FormData(),
        },
        methods: {
            logout: function () {
                this.$http.get('/logout').then(function(response) {
                    this.loggedIn = false;
                    this.user = null;
                    this.isAdmin = false;
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
            },
            toggleFeatured: function() {
                this.featuredShowing = false;
            },
            loadQuestions: function() {
                this.$http.post('/api/question/get',
                {
                    recipient_id: recipient.id,
                    topic_id: this.topic.id,
                    sort: this.sortType,
                    offset: this.questions.length
                }, function(data){
                    for (var c = 0; c < data.length; c++) {
                        data[c].created_at = moment.utc(data[c].created_at).toDate();
                        if (data[c].answer != null) {
                            data[c].answer.created_at = moment.utc(data[c].answer.created_at).toDate();
                        }
                        this.questions.push(data[c]);
                    }
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
                for (var c = 0; c < questions.length; c++) {
                    questions[c].created_at = moment.utc(questions[c].created_at).toDate();
                    if (questions[c].answer != null) {
                        questions[c].answer.created_at = moment.utc(questions[c].answer.created_at).toDate();
                    }
                }
                this.questions = questions;
            },
            'show-signup-modal': function() {
                this.showLoginModal = true;
            },
            'update-question-sort': function(sortType) {
                this.$http.post('/api/question/get',
                {
                    recipient_id: recipient.id,
                    topic_id: this.topic.id,
                    sort: sortType,
                    offset: 0
                }, function(data){
                    this.questions = data;
                    this.questionOffset = 0;
                    this.questionEnd = false;
                    this.sortType = sortType;
                }).error(function (data, status, request) {
                    //error handling here
                });
            }
        }
    });

})();
