(function(){
    'use strict';

    Vue.component('ask', {
        template: '#ask-template',
        data: function() {
            return {
                question_text: '',
                open: false,
                asked: false,
                errorMsg: ''
            };
        },
        props: [ 'user', 'recipient' ],
        methods: {
            toggle: function() {
                this.open = !this.open;
                this.$nextTick( function() {
                    this.$els.questionText.focus();
                });
            },
            sendQuestion: function() {
                this.errorMsg = '';
                this.$http.post('/api/question/store',
                {
                    recipient_id: this.recipient.id,
                    asker_id: this.user.id,
                    question: this.question_text
                })
                .then(function (response) {
                    if (response.data.success) {
                        this.$dispatch('questions-updated', response.data.data);
                        this.open = false;
                        this.question_text = '';
                        this.asked = true;
                    } else {
                        this.errorMsg = response.data.error;
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

})();
