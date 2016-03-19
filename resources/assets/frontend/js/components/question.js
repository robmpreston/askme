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
            // GET request
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
            // GET request
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
