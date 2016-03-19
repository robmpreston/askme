(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient', 'loggedIn'],
        methods: {
            like: function(answerId) {
                if (this.loggedIn) {
                    this.answer.upvoted = !this.answer.upvoted;

                    this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                        if (!response.data.success) {
                            this.answer.upvoted = !this.answer.upvoted;
                        }
                    }, function (response) {
                        this.answer.upvoted = !this.answer.upvoted;
                    });
                }
            }
        },
        computed: {
            votes: function() {
                if (this.answer.upvoted) {
                    return this.answer.net_votes + 1;
                } else {
                    return this.answer.net_votes;
                }
            }
        }
    });

})();
