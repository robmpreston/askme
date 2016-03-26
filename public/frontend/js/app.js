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
        props: [ 'user', 'recipient', 'loggedIn' ],
        methods: {
            toggle: function() {
                if (this.loggedIn) {
                    this.open = !this.open;
                    this.$nextTick( function() {
                        this.$els.questionText.focus();
                    });
                } else {
                    this.showSignupModal();
                }
            },
            sendQuestion: function() {
                this.errorMsg = '';
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
                    } else {
                        this.errorMsg = response.data.error;
                    }
                }, function (response) {
                    console.log('failed');
                });
            },
            showSignupModal: function() {
                this.$dispatch('show-signup-modal');
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
                            if (response.data.success) {
                                this.$dispatch('questions-updated', response.data.data);
                            }
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
            },
            shareText: function() {
                return 'Ask ' + this.recipient.first_name;
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
                } else {
                    this.showSignupModal();
                }
            },
            showSignupModal: function() {
                this.$dispatch('show-signup-modal');
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
                        console.log(response.data.data.user);
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
            document.addEventListener("keydown", function (e) {
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
                from: '',
                email: '',
                password: '',
                errorText: ''
            };
        },
        methods: {
            close: function () {
                this.show = false;
                this.login = false;
                this.firstName = '';
                this.lastName = '';
                this.email = '';
                this.password = '';
                this.title = '';
                this.body = '';
            },
            toggle: function() {
                this.login = !this.login;
                this.errorText = '';
                this.firstName = '';
                this.lastName = '';
                this.email = '';
                this.password = '';
                this.from = '';
            },
            emailLogin: function () {
                var self = this;
                this.$http.post('/api/login', { email: this.email, password: this.password }).then(function (response) {
                    if (!response.data.success) {
                        self.errorText = 'Email or password is incorrect.';
                    } else {
                        self.errorText = '';
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                });
            },
            emailSignup: function () {
                var self = this;
                this.$http.post('/api/user/store',
                { first_name: this.firstName, last_name: this.lastName, from: this.from, email: this.email, password: this.password })
                .then(function (response) {
                    if (!response.data.success) {
                    } else {
                        this.errorText = '';
                        this.$dispatch('user-updated', response.data.data.user);
                        this.close();
                    }
                }, function (response) {
                    if (response.status == '422') {
                        self.errorText = '';
                        Object.keys(response.data).forEach(function (key) {
                           self.errorText += response.data[key][0] + '<br/>';
                        });
                    }
                });
            }
        },
        computed: {
            loginValidated: function () {
                return (this.email != '' && this.password != '');
            },
            signupValidated: function() {
                return (this.firstName != '' && this.lastName != '' && this.from != '' && this.email != '' && this.password != '');
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
                this.$http.post('/api/user/update',
                { first_name: this.user.first_name, last_name: this.user.last_name, from: this.user.from, email: this.user.email, password: this.password })
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
                    && this.user.from != '' && this.user.email != '');
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

    Vue.component('sorting', {
        template: '#sorting-template',
        props: [ 'sortType' ],
        methods: {
            sort: function(type) {
                this.sortType = type;
                this.$dispatch('update-question-sort', this.sortType);
            }
        }
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

    Vue.component('youtube', {
        template: '#youtube-template',
        props: [ 'videoId' ]
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
            featuredQuestion: featuredQuestion,
            featuredShowing: true,
            sortType: 'trending',
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
            }
        },
        events: {
            'user-updated': function (user) {
                this.user = user;
                this.loggedIn = true;
            },
            'questions-updated': function(questions) {
                this.questions = questions;
            },
            'show-signup-modal': function() {
                this.showLoginModal = true;
            },
            'update-question-sort': function(sortType) {
                this.$http.post('/api/question/get', { recipient_id: recipient.id, sort: sortType}, function(data){
                    this.questions = data;
                }).error(function (data, status, request) {
                    //error handling here
                });
            }
        }
    });

})();

//# sourceMappingURL=app.js.map
