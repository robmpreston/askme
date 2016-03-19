(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient', 'loggedIn'],
        data: function() {
            return {
                liked: false
            };
        },
        methods: {
            like: function(answerId) {
                if (this.loggedIn) {
                    this.liked = !this.liked;

                    this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                        if (!response.data.success) {
                            this.liked = !this.liked;
                        }
                    }, function (response) {
                        this.liked = !this.liked;
                    });
                }
            }
        },
        computed: {
            votes: function() {
                if (this.liked) {
                    return this.answer.net_votes + 1;
                } else {
                    return this.answer.net_votes;
                }
            }
        }
    });

})();
