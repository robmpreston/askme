(function(){
    'use strict';

    Vue.component('question', {
        template: '#question-template',
        props: ['question', 'recipient', 'loggedIn', 'isAdmin', 'baseUrl'],
        data: function() {
            return {
                replyOpen: false,
                answerText: ''
            }
        },
        methods: {
            upvote: function(questionId) {
                if (this.loggedIn) {
                    this.question.upvoted = !this.question.upvoted;
                    this.question.downvoted = false;
                    this.$http.post('/api/question/upvote', { question_id: questionId }).then(function (response) {
                        if (!response.data.success) {
                            this.question.upvoted = !this.question.upvoted;
                        } else {
                            this.question.net_votes = response.data.data.net_votes;
                        }
                    }, function (response) {
                        this.question.upvoted = !this.question.upvoted;
                    });
                } else {
                    this.showSignupModal();
                }
            },
            downvote: function(questionId) {
                if (this.loggedIn) {
                    this.question.downvoted = !this.question.downvoted;
                    this.question.upvoted = false;

                    this.$http.post('/api/question/downvote', { question_id: questionId }).then(function (response) {
                        if (!response.data.success) {
                            this.question.downvoted = !this.question.downvoted;
                        } else {
                            this.question.net_votes = response.data.data.net_votes;
                        }
                    }, function (response) {
                        this.question.downvoted = !this.question.downvoted;
                    });
                } else {
                    this.showSignupModal();
                }
            },
            hide: function() {
                if (this.loggedIn && this.isAdmin) {
                    this.$http.post('/api/question/hide', { question_id: this.question.id })
                        .then(function (response) {

                        });
                }
            },
            reply: function(e) {
                e.preventDefault();
                this.replyOpen = true;
            },
            submitAnswer: function(e) {
                e.preventDefault();
                if (this.loggedIn && this.isAdmin) {
                    this.$http.post('/api/answer/store',
                    {
                        question_id: this.question.id,
                        text_response: this.answerText,
                        video_url: this.answerVideo
                    }).then(function (response) {
                        if (response.data.success) {
                            this.replyOpen = false;
                            this.answerText = '';
                            this.question.answer = response.data.data.answer;
                        }
                    });
                }
            },
            cancelAnswer: function(e) {
                e.preventDefault();
                this.replyOpen = false;
            },
            showSignupModal: function() {
                this.$dispatch('show-signup-modal');
            }
        },
        computed: {
            shareUrl: function() {
                return this.baseUrl + '/' + this.question.id;
            }
        }
    });

})();
