var Vue = require('vue');
var Question = require('./components/question.vue');

new Vue({
    el: '#app',
    components: {
        'question' : Question
    }
})
