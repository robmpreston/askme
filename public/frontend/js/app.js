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
        upvote: function() {
            this.upvoted = !this.upvoted;
            this.downvoted = false;
            // GET request
            this.$http({url: '/api/question/upvote', method: 'GET'}).then(function (response) {
                if (response.data.success) {
                    console.log('success!');
                } else {
                    this.upvoted = !this.upvoted;
                }
            }, function (response) {
                this.upvoted = !this.upvoted;
            });
        },
        downvote: function() {
            this.downvoted = !this.downvoted;
            this.upvoted = false;
            // GET request
            this.$http({url: '/api/question/downvote', method: 'GET'}).then(function (response) {
                if (response.data.success) {
                    console.log('success!');
                } else {
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
                return this.question.votes + 1;
            } else if (this.downvoted) {
                return this.question.votes - 1;
            } else {
                return this.question.votes;
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
        like: function() {
            this.liked = !this.liked;
            // GET request
            this.$http({url: '/api/answer/like', method: 'GET'}).then(function (response) {
                if (response.data.success) {
                    console.log('success!');
                } else {
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
                return this.answer.votes + 1;
            } else {
                return this.answer.votes;
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

var vm = new Vue({
    el: '#app',
    data: {
        showLoginModal: false,
        user: {
            profile_image: "https://www.teachforamerica.org/sites/default/files/styles/list_thumbnail/public/blog/author/photos/deray2.png",
            first_name: "DeRay",
            last_name: "Mckesson",
            title: "Mayoral Candidate",
            location: "Baltimore, MD",
            description: "Running for Mayor of Baltimore. I am an organizer, activist and educator focused primarily on issues of innovation, equity and justice."
        },
        questions: [{
            text: "What are your thoughts on Donald Trump?",
            votes: 5,
            answer: {
                text: "Great question Billy Bob. Donald Trump is a rare breed of asshole. A real scum sucking shithead. I'd love to get him alone in a room so I could bash his brains in. Does that help?",
                votes: 1000
            }
        }, {
            text: "Is Barack Hussein Obama a muslim terrorist?",
            votes: 50,
            answer: {
                text: "Thanks for the question Little Marco. Little known fact, Obama actually started ISIS when he was growing up in Africa. So the answer is a resounding yes.",
                votes: 55
            }
        }, {
            text: "What is your opinion on Super PACs?",
            votes: 11,
            answer: {
                text: "Well Joey, any way I can get more money to my people I will do it. Those people behind the scenes running the show? They're pumping money into my Super PAC which is getting paid out to all of my friends. What a world!",
                votes: 95
            }
        }]
    }
})

//# sourceMappingURL=app.js.map
