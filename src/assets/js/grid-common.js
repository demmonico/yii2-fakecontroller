/**
 * Created by dep on 17.01.17.
 */

(function ($) {

    var container = $('#pjax_container');

    // delete btn
    container.on('click', '.grid-btn-delete', function (e){
        e.preventDefault();
        var self = $(this);
        var url = container.data('url-delete')+'?id='+self.data('id');
        swal({
                title: "Delete",
                text: "Are you sure to delete this item?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function (data) {
                            if(data)
                                $.pjax.reload({container: '#pjax_container'});
                            else
                                sweetAlert("Oops...",'Some error!', "error");
                        }
                    });
                }
            }
        );
    });

    // form submit, change
    $('#per-page-form').on('submit change', function(e){
        jQuery.pjax.submit(e);
    });

})(jQuery);
