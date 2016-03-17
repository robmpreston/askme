Vue.component('ask', {
    template: '#ask-template',
    data: function() {
        return {
            question: '',
            open: false
        };
    },
    methods: {
        toggle: function() {
            this.open = !this.open;
        }
    }
});
