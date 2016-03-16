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
