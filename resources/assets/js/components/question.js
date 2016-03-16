Vue.component('question', {
    template: "#question-template",
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
