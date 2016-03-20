(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient', 'loggedIn', 'isAdmin'],
        methods: {
            like: function(answerId) {
                if (this.loggedIn) {
                    this.answer.upvoted = !this.answer.upvoted;

                    this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                        if (!response.data.success) {
                            this.answer.upvoted = !this.answer.upvoted;
                        } else {
                            this.answer.net_votes = response.data.data.net_votes;
                        }
                    }, function (response) {
                        this.answer.upvoted = !this.answer.upvoted;
                    });
                }
            }
        },
        computed: {
        }
    });

})();
