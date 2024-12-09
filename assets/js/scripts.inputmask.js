// $(document).ready(function() {
//     $('.maskiban').mask('SS00 0000 0000 0000 0000 00', {
//         placeholder: '____ ____ ____ ____ ____ __'
//     });
// });

// Class definition
// https://github.com/RobinHerbots/Inputmask

var KTInputmask = function () {

    // Private functions
    var demos = function () {
        // iban format
        $(".inputmaskIban").inputmask(["aa9{2} *{4} *{4} *{4} *{4} *{4} *{2}"], {
            keepStatic: false,
            clearMaskOnLostFocus: false,
            casing: "upper"
        });



        var inputmaskPlakas = ['9{2} a{1} 9{4}', '9{2} a{2} 9{3,4}', '9{2} a{3} 9{3}', '(YAYA|yaya)'];
        $('.inputmaskPlaka').inputmask({
            mask: inputmaskPlakas,
            keepStatic: true,
            clearMaskOnLostFocus: false,
            casing: "upper"

        });

        //Inputmask({ regex: "(is|red|blue)" }).mask('.inputmaskPlaka');


        $(".inputmaskDecimal").inputmask({
            //alias: 'decimal',
            regex : '^[\\d\\(\\)\\-+,.]+$',
            groupSeparator: '.',
            radixPoint: ',',
            placeholder: '',
            numericInput: true,
            autoGroup: true,
            rightAlign: true
        });


        /*
        // date format
        $("#kt_inputmask_1").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
            autoUnmask: true
        });

        // custom placeholder
        $("#kt_inputmask_2").inputmask("99/99/9999", {
            "placeholder": "mm/dd/yyyy",
        });

        // phone number format
        $("#kt_inputmask_3").inputmask("mask", {
            "mask": "(999) 999-9999"
        });

        // empty placeholder
        $("#kt_inputmask_4").inputmask({
            "mask": "99-9999999",
            placeholder: "" // remove underscores from the input mask
        });

        // repeating mask
        $("#kt_inputmask_5").inputmask({
            "mask": "9",
            "repeat": 10,
            "greedy": false
        }); // ~ mask "9" or mask "99" or ... mask "9999999999"

        // decimal format
        $("#kt_inputmask_6").inputmask('decimal', {
            rightAlignNumerics: false
        });

        // currency format
        $("#kt_inputmask_7").inputmask('â‚¬ 999.999.999,99', {
            numericInput: true
        }); //123456  =>  â‚¬ ___.__1.234,56

        //ip address
        $("#kt_inputmask_8").inputmask({
            "mask": "999.999.999.999"
        });

        //email address
        $("#kt_inputmask_9").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });
         */
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTInputmask.init();
});