(function(){
    'use strict';

    Vue.component('answer', {
        template: '#answer-template',
        props: ['answer', 'recipient', 'loggedIn', 'isAdmin'],
        methods: {
            like: function(answerId) {
                if (this.loggedIn) {
                    this.answer.liked = !this.answer.liked;

                    this.$http.post('/api/answer/like', { answer_id: answerId }).then(function (response) {
                        if (!response.data.success) {
                            this.answer.liked = !this.answer.liked;
                        } else {
                            this.answer.net_votes = response.data.data.count;
                        }
                    }, function (response) {
                        this.answer.liked = !this.answer.liked;
                    });
                }
            }
        },
        computed: {
        }
    });

})();
