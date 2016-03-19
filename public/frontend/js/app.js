(function(){
    'use strict';

    Vue.component('ask', {
        template: '#ask-template',
        data: function() {
            return {
                question_text: '',
                open: false
            };
        },
        props: [ 'user', 'recipient' ],
        methods: {
            toggle: function() {
                this.open = !this.open;
            },
            sendQuestion: function() {
                this.$http.post('/api/question/store',
                {
                    recipient_id: this.recipient.id,
                    asker_id: this.user.id,
                    question: this.question_text
                })
                .then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.$dispatch('questions-updated', response.data.data);
                        this.$dispatch('question-asked');
                    }
                }, function (response) {
                    console.log('failed');
                });
            }
        },
        events: {
            'question-asked': function() {
                this.open = false;
                this.question_text = '';
            }
        }
    });

})();

(function(){
    'use strict';

    Vue.component('question', {
        template: '#question-template',
        props: ['question', 'recipient'],
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

})();

(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient'],
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

})();

(function(){
    'use strict';

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

})();

(function(){
    'use strict';

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

})();

(function(){
    'use strict';

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
                    } else {
                        this.$dispatch('user-updated', response.data.data);
                    }
                }, function (response) {
                    console.log('failed');
                });
                this.close();
            }
        }
    });

})();

(function(){
    'use strict';

    var vm = new Vue({
        el: '#app',
        data: {
            showLoginModal: false,
            recipient: recipient,
            questions: questions,
            loggedIn: loggedIn,
            user: user
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

//# sourceMappingURL=app.js.map
