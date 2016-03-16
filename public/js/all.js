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

var vm = new Vue({
    el: '#app',
    data: {
        questions: [{
            text: "What are your thoughts on Donald Trump?",
            votes: 5
        }, {
            text: "Is Barack Hussein Obama a muslim terrorist?",
            votes: 50
        }, {
            text: "What is your opinion on Super PACs?",
            votes: 11
        }]
    }
})

//# sourceMappingURL=all.js.map
