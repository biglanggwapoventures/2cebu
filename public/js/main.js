jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.modal').on('show.bs.modal', function() {
        var form = $(this).find('form');
        form[0].reset();
        form.find('.invalid-feedback').remove();
        form.find('.is-invalid').removeClass('is-invalid')
    })
    $('form.ajax').submit(function (e) {
        e.preventDefault();

        var $this = $(this),
            submitBtn = $this.find('[type=submit]'),
            originalText = submitBtn.text(),
            formData = new FormData($this[0]);

        $this.find('.invalid-feedback').remove();
        $this.find('.is-invalid').removeClass('is-invalid')

        submitBtn.attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i> Loading...')

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.hasOwnProperty('data') && res.data.hasOwnProperty('location')){
                    window.location.href = res.data.location;
                }else if($this.data('next-url')){
                    window.location.href = $this.data('next-url');
                }else{
                    window.location.reload();
                }
            },
            error: function (err) {
                if(err.status == 422){
                    // alertify.alert('Ooops!', 'Some fields contain errors. Please verify that all inputs are valid and try submitting again.');
                    var errors = err.responseJSON['errors'];

                    for(var field in errors){
                        var fieldName = field;
                        if(field.indexOf('.') !== -1){
                            var parts = field.split('.'),
                                name = parts.splice(0, 1),
                                newField = name+'['+parts.join('][')+']';

                            fieldName = newField;
                        }

                        console.log(fieldName)

                        var input = $this.find("[name=\""+fieldName+"\"]");
                        input.addClass('is-invalid');
                        input.closest('.form-group').append('<div class="invalid-feedback">'+errors[field][0]+'</div>');

                    }
                }else{
                    alertify.alert('An internal server error has occured. Please refresh the page. If the error still persists. Please contact your system administrator.');
                }
            },
            complete: function () {
                submitBtn.removeAttr('disabled').text(originalText);
            }
        })
    })
    $('body').on('click', '.trash-row', function () {
        if(!confirm('Are you sure you want to delete this entry? This action cannot be undone!')) return;
        $(this).closest('form').submit();
    });

    $('.logout').click(function () {
        if(!confirm('Are you sure you want to logout?')) return;
        $('#logout-form').submit();
    })

    $('.add-line').click(function() {
        var table = $(this).closest('table'),
            clone = table.find('tbody tr:first').clone();
            clone.find('select,input:not([type=hidden])')
            .attr('name', function () {
                return $(this).data('name').replace('idx', table.find('tbody tr').length)
            })
            .val('');
        clone.find('.clear').html('')
        clone.find('[type=hidden]').remove();
        clone.appendTo(table.find('tbody'))
    })

    $('table.dynamic').on('click', '.remove-line', function () {
        var table = $(this).closest('table'),
            tr = table.find('tbody tr');
        if(tr.length === 1){
            tr.find('select,input').val('')
                .end()
                .find('.clear').html('')
                .end()
                .find('[type=hidden]').remove()
            return;
        }
        $(this).closest('tr').remove();
    });


    $('#myTab a').click(function(e) {
      e.preventDefault();
      $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
      var id = $(e.target).attr("href").substr(1);
      window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');


});
