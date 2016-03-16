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
                return this.question.votes + 1;
            } else {
                return this.question.votes;
            }
        }
    }
});
