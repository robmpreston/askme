(function(){
    'use strict';

    Vue.component('ask', {
        template: '#ask-template',
        data: function() {
            return {
                question_text: '',
                open: false,
                asked: false,
                errorText: ''
            };
        },
        props: [ 'user', 'recipient', 'loggedIn', 'topic' ],
        methods: {
            toggle: function() {
                if (this.loggedIn) {
                    this.open = !this.open;
                    this.$nextTick( function() {
                        this.$els.questionText.focus();
                    });
                } else {
                    this.showSignupModal();
                }
            },
            sendQuestion: function() {
                this.errorText = '';
                this.$http.post('/api/question/store',
                {
                    recipient_id: this.recipient.id,
                    topic_id: this.topic.id,
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
                        this.errorText = response.data.error;
                    }
                }, function (response) {
                    console.log('failed');
                });
            },
            showSignupModal: function() {
                this.$dispatch('show-signup-modal');
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
