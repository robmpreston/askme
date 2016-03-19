Vue.component('ask', {
    template: '#ask-template',
    data: function() {
        return {
            question: '',
            open: false
        };
    },
    props: [ 'user' ],
    methods: {
        toggle: function(holder) {
            this.open = !this.open;
            if (this.open) {
                holder.$$.questionTextArea.focus()
            } else {
                holder.$$.questionTextInput.focus()
            }
        }
    }
});
