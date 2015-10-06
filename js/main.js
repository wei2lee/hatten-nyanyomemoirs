$(document).ready(function() {
    $form = $('#form form');

    var _fields = {}
    _fields[('name')] = {
        validators: {
            notEmpty: {
                message: 'Please Enter Your Name'
            }
        }
    };
    _fields[('phone')] = {
        validators: {
            notEmpty: {
                message: 'Please Enter Your Contact No'
            }
        }
    };
    _fields[('email')] = {
        validators: {
            notEmpty: {
                message: 'Please Enter Your Email'
            }
        }
    };
    _fields['agree'] = {
        validators: {
            notEmpty: {
                message: 'Please accept the Privacy policy'
            }
        }
    }

    $form.bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: _fields
    }).on('success.form.bv', function (e) {
        console.log('success.form.bv');
        e.preventDefault();
        var $form = $(e.target);
        var $bv = $form.data('bootstrapValidator');
        $data = {}
        $data['name'] = $form.find('[name=name]').val();
        $data['phone'] = $form.find('[name=phone]').val();
        $data['email'] = $form.find('[name=email]').val();
        $.post($form.attr('action'), $data, function (result) {
            if (result.error_exist) {
                bootbox.alert('Fail to submit : ' + result.error_message);
                $form.data('bootstrapValidator').disableSubmitButtons(false);
            } else {
                var bb = bootbox.confirm('Successfully sumbitted.', function () {});
                $form.data('bootstrapValidator').resetForm();
                $form[0].reset();
            }
        }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
            $form.data('bootstrapValidator').disableSubmitButtons(false);
            bootbox.alert('Fail to submit : ' + errorThrown);
        });
    });
    $form.on('reset', function () {
        $form.data('bootstrapValidator').resetForm();
    }); 
});