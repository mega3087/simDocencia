(function($, window) {

    var dev = '.dev'; //window.location.hash.indexOf('dev') > -1 ? '.dev' : '';

    // Add a new validator
    $.formUtils.addValidator({
        name : 'alpha',
        validatorFunction : function(value, $el, config, language, $form) {
            return /^[a-záéíóúÁÉÍÓÚüÜñÑ\s]+$/i.test(value);
        },
        borderColorOnError : '',
        errorMessage : 'El campo debe contener sólo caracteres alfabéticos.',
        errorMessageKey: 'badEvenNumber',
    });

    window.applyValidation = function(validateOnBlur, forms, messagePosition, xtraModule) {
        if( !forms )
            forms = 'form';
        if( !messagePosition )
            messagePosition = 'top';

        $.validate({
            form : forms,
            language : {
                requiredFields: 'Este campo es requerido'
            },
            validateOnBlur : validateOnBlur,
            errorMessagePosition : messagePosition,
            lang : 'es',
			validateHiddenInputs: true, // whether or not hidden inputs should be validated
			scrollToTopOnError : true,
			validationRuleAttribute: 'data-validation',
            sanitizeAll : 'trim', // only used on form C
           // borderColorOnError : 'purple',
            modules : 'security'+dev+', location'+dev+', sweden'+dev+', file'+dev+', uk'+dev+' , brazil'+dev +( xtraModule ? ','+xtraModule:''),
            onModulesLoaded: function() {
                $('#country-suggestions').suggestCountry();
                $('#swedish-county-suggestions').suggestSwedishCounty();
                $('#password').displayPasswordStrength();
            },
            onValidate : function($f) {

                console.log('about to validate form '+$f.attr('id'));

                var $callbackInput = $('#callback');
                if( $callbackInput.val() == 1 ) {
                    return {
                        element : $callbackInput,
                        message : 'Esta validación se realizó en una devolución de llamada'
                    };
                }
            },
            onError : function($form) {
                //alert('Invalid '+$form.attr('id'));
            },
            onSuccess : function($form) {
                //alert('Valid '+$form.attr('id'));
				("form").submit();
                return false;
            }
        });
    };

    $('#text-area').restrictLength($('#max-len'));

    window.applyValidation(true, '#form-a', 'top');
    window.applyValidation(false, '#form-b', 'element');
    window.applyValidation(true, '#form-c', function() {
        console.log('in here then');
        return $('#error-container');
    }, 'sanitize'+dev);
    window.applyValidation(true, '#form-d', 'element', 'html5'+dev);
    window.applyValidation(true, '#form-e');

    // Load one module outside $.validate() even though you do not have to
    $.formUtils.loadModules('date'+dev+'.js', false, false);

    $('input')
        .on('beforeValidation', function() {
            console.log('About to validate input "'+this.name+'"');
        })
        .on('validation', function(evt, isValid) {
            var validationResult = '';
            if( isValid === null ) {
                validationResult = 'not validated';
            } else if( isValid ) {
                validationResult = 'VALID';
            } else {
                validationResult = 'INVALID';
            }
            console.log('Input '+this.name+' is '+validationResult);
        });

})(jQuery, window);