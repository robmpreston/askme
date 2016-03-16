var Vue = require('vue');
var Question = require('./components/question.vue');

new Vue({
    el: '#app',
    data: {
        questions: [{
            text: "What are your thoughts on Donald Trump?",
            votes: 5
        }, {
            text: "Is Barack Hussein Obama a muslim terrorist?",
            votes: 50
        }, {
            text: "What is your opinion on Super PACs?",
            votes: 11
        }]
    }
})
