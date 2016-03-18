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
                if (!response.data.success) {
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
                return this.question.votes + 1;
            } else if (this.downvoted) {
                return this.question.votes - 1;
            } else {
                return this.question.votes;
            }
        }
    }
});
