var vm = new Vue({
    el: '#app',
    data: {
        showLoginModal: false,
        recipient: recipient,
        questions: questions,
        loggedIn: loggedIn,
        user: user
    },
    events: {
        'user-updated': function (user) {
            this.user = user;
            this.loggedIn = true;
        }
    }
})
