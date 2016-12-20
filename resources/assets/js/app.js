
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$('.popOver').popover();
// http://stackoverflow.com/questions/8982295/confirm-delete-modal-dialog-with-twitter-bootstrap

(function() {

    var laravel = {
        initialize: function() {
            this.methodLinks = $('a[data-method]');

            this.registerEvents();
        },

        registerEvents: function() {
            this.methodLinks.on('click', this.handleMethod);
        },

        handleMethod: function(e) {
            e.preventDefault();
            console.log(window.Laravel)

            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;

            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === - 1 ) {
                return;
            }

            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm') ) {
                if ( ! laravel.verifyConfirm(link) ) {
                    return false;
                }
            }

            form = laravel.createForm(link);
            debugger;
            form.submit();
            //window.location.href = "/";
            e.preventDefault();
        },

        verifyConfirm: function(link) {
            return confirm(link.data('confirm'));
        },

        createForm: function(link) {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': link.attr('href')
                });

            var token =
                $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': window.Laravel.csrfToken // hmmmm...
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': link.data('method')
                });

            return form.append(token, hiddenInput)
                .appendTo('body');
        }
    };

    laravel.initialize();

})();

/*
$('a[data-confirm]').click(function(ev) {
    var href = $(this).attr('href');

    if (!$('#dataConfirmModal').length) {
        $('body').append(
            '<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
            '<h3 id="dataConfirmLabel">Please Confirm</h3>' +
            '</div>' +
            '<div class="modal-body">' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>' +
            '<a class="btn btn-primary" data-method="delete" data-confirm="Are you sure?" id="dataConfirmOK">Delete</a>'+
            '</div>' +
            '</div>');
    }
    $("#dataConfirmOK").attr("href",$(this).attr("data-href"));
    $('#dataConfirmModal').modal({show:true});
    return false;
});*/
