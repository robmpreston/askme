Vue.component('ask', {
    template: '#ask-template',
    data: function() {
        return {
            question: '',
            open: false
        };
    },
    methods: {
        toggle: function() {
            this.open = !this.open;
        }
    }
});

Vue.component('question', {
    template: '#question-template',
    props: ['question'],
    data: function() {
        return {
            upvoted: false,
            downvoted: false
        };
    },
    methods: {
        upvote: function(questionId) {
            this.upvoted = !this.upvoted;
            this.downvoted = false;
            // GET request
            this.$http.post('/api/question/upvote', { question_id: questionId }).then(function (response) {
                if (!response.data.success) {
                    this.upvoted = !this.upvoted;
                }
            }, function (response) {
                this.upvoted = !this.upvoted;
            });
        },
        downvote: function(questionId) {
            this.downvoted = !this.downvoted;
            this.upvoted = false;
            // GET request
            this.$http.post('/api/question/downvote', { question_id: questionId }).then(function (response) {
                if (!response.data.success) {
                    this.downvoted = !this.downvoted;
                }
            }, function (response) {
                this.downvoted = !this.downvoted;
            });
        }
    },
    computed: {
        votes: function() {
            if (this.upvoted) {
                return this.question.net_votes + 1;
            } else if (this.downvoted) {
                return this.question.net_votes - 1;
            } else {
                return this.question.net_votes;
            }
        }
    }
});

Vue.component('answer', {
    template: '#answer-template',
    props: ['answer'],
    data: function() {
        return {
            liked: false
        };
    },
    methods: {
        like: function(answerId) {
            this.liked = !this.liked;
            // GET request
            this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                if (!response.data.success) {
                    this.liked = !this.liked;
                }
            }, function (response) {
                this.liked = !this.liked;
            });
        }
    },
    computed: {
        votes: function() {
            if (this.liked) {
                return this.answer.net_votes + 1;
            } else {
                return this.answer.net_votes;
            }
        }
    }
});

Vue.component('feature', {
    template: '#feature-template',
    props: ['user'],
    data: function() {
    },
    methods: {
    },
    computed: {
        name: function() {
            return this.user.first_name + ' ' + this.user.last_name;
        }
    }
});

Vue.component('modal', {
    template: '#modal-template',
    props: ['show', 'onClose'],
    methods: {
        close: function () {
            this.onClose();
        }
    },
    ready: function () {
        document.addEventListener("keydown", (e) => {
            if (this.show && e.keyCode == 27) {
                this.onClose();
            }
        });
    }
});

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

console.log(questions);
var vm = new Vue({
    el: '#app',
    data: {
        showLoginModal: false,
        recipient: recipient,
        questions: questions
    }
})

//# sourceMappingURL=app.js.map
