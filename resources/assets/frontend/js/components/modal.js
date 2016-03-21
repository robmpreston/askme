(function(){
    'use strict';

    Vue.component('modal', {
        template: '#modal-template',
        props: ['show', 'onClose'],
        methods: {
            close: function () {
                this.onClose();
            }
        },
        ready: function () {
            document.addEventListener("keydown", function (e) {
                if (this.show && e.keyCode == 27) {
                    this.onClose();
                }
            });
        }
    });

})();
