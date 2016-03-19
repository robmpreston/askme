(function(){
    'use strict';

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
                if (this.open) {
                    this.$els.questionText.focus();
                }
            },
            sendQuestion: function() {
                this.$http.post('/api/question/store',
                {
                    recipient_id: this.recipient.id,
                    asker_id: this.user.id,
                    question: this.question_text
                })
                .then(function (response) {
                    this.$dispatch('questions-updated', response.data.data);
                    this.open = false;
                    this.question_text = '';
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

})();
