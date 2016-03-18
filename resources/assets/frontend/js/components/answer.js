Vue.component('answer', {
    template: '#answer-template',
    props: ['answer'],
    data: function() {
        return {
            liked: false
        };
    },
    methods: {
        like: function() {
            this.liked = !this.liked;
            // GET request
            this.$http({url: '/api/answer/like', method: 'GET'}).then(function (response) {
                if (!response.data.success) {
                    this.liked = !this.liked;
                }
            }, function (response) {
                this.liked = !this.liked;
            });
        }
    },
    computed: {
        votes: function() {
            if (this.liked) {
                return this.answer.votes + 1;
            } else {
                return this.answer.votes;
            }
        }
    }
});
