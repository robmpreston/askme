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
        methods: {
            toggle: function(event) {
                this.open = !this.open;
                console.log(this.$el);
                // var self = this;
                // Vue.nextTick(function () {
                //
                //     // self.$$.questionInput.focus();
                // });
            }
        }
    });

})();
