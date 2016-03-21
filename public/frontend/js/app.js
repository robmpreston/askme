(function(){
    'use strict';

    Vue.component('ask', {
        template: '#ask-template',
        data: function() {
            return {
                question_text: '',
                open: false,
                asked: false,
                errorMsg: ''
            };
        },
        props: [ 'user', 'recipient' ],
        methods: {
            toggle: function() {
                this.open = !this.open;
                this.$nextTick( function() {
                    this.$els.questionText.focus();
                });
            },
            sendQuestion: function() {
                this.$http.post('/api/question/store',
                {
                    recipient_id: this.recipient.id,
                    asker_id: this.user.id,
                    question: this.question_text
                })
                .then(function (response) {
                    if (response.data.success) {
                        this.$dispatch('questions-updated', response.data.data);
                        this.open = false;
                        this.question_text = '';
                        this.asked = true;
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
                    this.$http.post('/api/answer/store', { question_id: this.question.id, text_response: this.answerText })
                        .then(function (response) {
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
            }
        },
        computed: {
            shareUrl: function() {
                return this.baseUrl + '/' + this.question.id;
            }
        }
    });

})();

(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient', 'loggedIn', 'isAdmin'],
        methods: {
            like: function(answerId) {
                if (this.loggedIn) {
                    this.answer.liked = !this.answer.liked;

                    this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                        if (!response.data.success) {
                            this.answer.liked = !this.answer.liked;
                        } else {
                            this.answer.net_votes = response.data.data.count;
                        }
                    }, function (response) {
                        this.answer.liked = !this.answer.liked;
                    });
                }
            }
        },
        computed: {
        }
    });

})();

(function(){
    'use strict';

    Vue.component('feature', {
        template: '#feature-template',
        props: ['user', 'isAdmin'],
        data: function() {
            return {
                editing: false
            }
        },
        methods: {
            editProfile: function() {
                this.editing = true;
            },
            saveProfile: function() {
                this.$http.post('/api/user/profile/update',
                {
                    first_name: this.user.first_name,
                    last_name: this.user.last_name,
                    i_am_a: this.user.profile.i_am_a,
                    from: this.user.from,
                    description: this.user.profile.description
                }).then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.$dispatch('user-updated', response.data.data.user);
                    }
                }, function (response) {
                    console.log('failed');
                });
                this.editing = false;
            },
            cancel: function() {
                this.editing = false;
            }
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
                login: true,
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
                        this.$dispatch('user-updated', response.data.data.user);
                    }
                }, function (response) {
                    console.log('failed');
                });
                this.close();
            },
            emailSignup: function () {
                this.$http.post('/api/user/store',
                { first_name: this.firstName, last_name: this.lastName, email: this.email, password: this.password }).then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.$dispatch('user-updated', response.data.data.user);
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

(function(){
    'use strict';

    Vue.component('fbshare', {
        template: '#fbshare-template',
        props: [ 'link', 'text' ]
    });

})();

(function(){
    'use strict';

    Vue.component('tweet', {
        template: '#tweet-template',
        props: [ 'link', 'text' ]
    });

})();

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
                this.profileFormUpload.append('file', this.$els.fileinput.files[0]);
                this.$http.post('/api/user/picture', this.profileFormUpload, function(data){
                    this.user = data.data;
                    if (this.user.id == this.recipient.id) {
                        this.recipient.picture = this.user.picture;
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
                this.questions = questions;
            }
        }
    });

})();

//# sourceMappingURL=app.js.map
