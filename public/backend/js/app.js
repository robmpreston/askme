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
            this.http.
            this.upvoted = !this.upvoted;
            this.downvoted = false;
        },
        downvote: function() {
            this.downvoted = !this.downvoted;
            this.upvoted = false;
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
            upvoted: false
        };
    },
    methods: {
        upvote: function() {
            this.upvoted = !this.upvoted;
        }
    },
    computed: {
        votes: function() {
            if (this.upvoted) {
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

var vm = new Vue({
    el: '#app',
    data: {
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
