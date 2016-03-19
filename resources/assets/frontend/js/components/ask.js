Vue.component('ask', {
    template: '#ask-template',
    data: function() {
        return {
            question_text: '',
            open: false
        };
    },
    props: [ 'user', 'recipient' ],
    methods: {
        toggle: function() {
            this.open = !this.open;
        },
        sendQuestion: function() {
            this.$http.post('/api/question/store',
            {
                recipient_id: this.recipient.id,
                asker_id: this.user.id,
                question: this.question_text
            })
            .then(function (response) {
                if (!response.data.success) {
                } else {
                    this.$dispatch('questions-updated', response.data.data);
                    this.$dispatch('question-asked');
                }
            }, function (response) {
                console.log('failed');
            });
        }
    },
    events: {
        'question-asked': function() {
            this.open = false;
            this.question_text = '';
        }
    }
});
