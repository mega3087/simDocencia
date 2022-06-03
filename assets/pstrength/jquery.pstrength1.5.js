/* Codigo descargado de: http://lycee.behal.free.fr/spip/plugins/passe_complexe/jquery.pstrength.js.html
 * jQuery Password Strength Plugin (pstrength) - A jQuery plugin to provide accessibility functions
 * Author: Tane Piper (digitalspaghetti@gmail.com)
 * Website: http://digitalspaghetti.me.uk
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
 * This code uses a modified version of Steve Moitozo's algorithm (http://www.geekwisdom.com/dyn/passwdmeter)
 *
 * === Changelog ===
 * Version 1.3 spip plugin (19/10/2007) P. Andrews
 * added options for the too short and unsafe strings and colours
 * use \W to match special characers
 * remove 50 to the socre if the password contains a common word
 * test that we don't have consecutive repetitions of at least 3 same alphanumerical.
 *
 * Version 1.2 (03/09/2007)
 * Added more options for colors and common words
 * Added common words checked to see if words like 'password' or 'qwerty' are being entered
 * Added minimum characters required for password
 * Re-worked scoring system to give better results
 *
 * Version 1.1 (20/08/2007)
 * Changed code to be more jQuery-like
 *
 * Version 1.0 (20/07/2007)
 * Initial version.
 */
(function($){ 
    $.extend($.fn, {
        pstrength : function(options) {
            var options = $.extend({
                verdects: ["Contraseña muy insegura","Contraseña insegura","Contraseña medianamente segura","Contraseña segura","Contraseña muy segura","Contraseña corta","Contraseña muy simple e insegura"],
                widths: ["10%","25%","50%","75%","99%","1%","0%"],
                colors: ["#f00","#c06", "#f60","#3c0","#3f0","#f00","#ccc"],
                scores: [10,15,48,60],
                powMax: 1.4,
                common: ["password","sex","god","12345678","liverpool","letmein","qwerty","monkey"],
                minchar: 8,
                minchar_label: 'El mínimo de carácteres es: ',
                displayMin: false
            },options);

            return this.each(function(){
                var infoarea = $(this).attr('id');
                if (infoarea == undefined) infoarea = $(this).attr('name');
                
                if (options.displayMin) { // Check to see if we should display the minimum number of characteres
                    $(this).after('<div class="pstrength-minchar" id="' + infoarea + '_minchar">'+options.minchar_label + options.minchar + '</div>');
                }
                $(this).after('<div class="pstrength-info" id="' + infoarea + '_text"></div>');
                $(this).after('<div class="pstrength-bar" id="' + infoarea + '_bar" style="border: 1px solid white; font-size: 1px; height: 5px; width: 0px;"></div>');
                $(this).keyup(function(){
                    console.clear();
                    console.log("Ejecutando keyup");
                    
                   $.fn.runPassword($(this).val(), infoarea, options);
                });
            });
        },
        runPassword : function (password, infoarea, options){
            // Check password
            nPerc = $.fn.checkPassword(password, options);
            // Get controls Color and text
            var ctlBar = "#" + infoarea + "_bar";
            var ctlText = "#" + infoarea + "_text";

            if (!password) {
                strColor = "";
                strText = "";
                ctlBarWidth = "0%";
            } else if (nPerc <= -200) { //contains compound, too simple
                strColor = options.colors[6];
                strText = options.verdects[6];
                ctlBarWidth = options.widths[6];
            }
            else if (nPerc <= 0 && nPerc >= -199) { //too short
                strColor = options.colors[5];
                strText = options.verdects[5]; // Corta
                ctlBarWidth = options.widths[5];
            }
            else if(nPerc >= 0 && nPerc <= options.scores[0]) { // nPerc 0..10
                strColor = options.colors[0];
                strText = options.verdects[0]; // Contraseña muy insegura
                ctlBarWidth = options.widths[0];
            }
            else if (nPerc > options.scores[0] && nPerc <= options.scores[1]) { // nPerc 11..15
                strColor = options.colors[1];
                strText = options.verdects[1]; // Contraseña insegura
                ctlBarWidth = options.widths[1];
            }
            else if (nPerc > options.scores[1] && nPerc <= options.scores[2]) { // nPerc 16..30
                strColor = options.colors[2];
                strText = options.verdects[2]; // Contraseña regular
                ctlBarWidth = options.widths[2];
            }
            else if (nPerc > options.scores[2] && nPerc <= options.scores[3]) { // nPerc 31..40
                strColor = options.colors[3];
                strText = options.verdects[3]; // Contraseña segura
                ctlBarWidth = options.widths[3];
            }
            else { // nPerc >= 41
                strColor = options.colors[4];
                strText = options.verdects[4]; // Contraseña muy segura
                ctlBarWidth = options.widths[4];
            }

            $(ctlBar).css({width: ctlBarWidth});
            $(ctlBar).css({backgroundColor: strColor});
            $(ctlText).html("" + strText + "");
        },
        checkPassword : function(password, options) {
            var intScore = 0;
            // returns the value of x to the power of y.
            intScore = Math.pow(password.length,options.powMax);
            
            console.log("Valor inicial:"+intScore);
            // Check password length
            console.log("options.michars:"+options.minchar);
            if (password.length < options.minchar) {
                intScore -= 100;
                console.log("Password to short (-100):"+intScore);
            }  // Password too short

            // CHARACTERS CLASSES
            if (password.match(/[a-z]/))  {
                intScore += 1;
                console.log("At least one lower case (+1):"+intScore);
            } // [verified] at least one lower case letter
            if (password.match(/[A-Z]/)) {intScore += 5;
            console.log("At least one upper case (+5):"+intScore);
            }// [verified] at least one upper case letter

            // NUMBERS
            if (password.match(/\d+/)) {
                intScore += 5;
            console.log("At least one numero (+5):"+intScore);
            }// [verified] at least one number
            if (password.match(/(.*[0-9].*[0-9].*[0-9])/)) intScore += 7; // [verified] at least three numbers

            // SPECIAL CHAR
            if (password.match(/.\W/)) intScore += 5; // [verified] at least one special character
            
            if (password.match(/(.*\W.*\W)/)) intScore += 7; // [verified] at least two special characters

            // COMBOS
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) intScore +=2; // [verified] both upper and lower case
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) intScore +=3; // [verified] both letters and numbers
            if (password.match(/([a-zA-Z0-9].*\W)|(\W.*[a-zA-Z0-9])/)) intScore += 3;// [verified] letters, numbers, and special characters
            
            // PENALIZACIONES
            if(password.match(/(\w)\1{2}/)) {intScore -= 10;
            console.log("Cadena de caracteres alpanumeric (-10):"+intScore);
            }// the password contains a chain of 3 identical alphanumeric character (aaaXk, bbbbbb19, ...)
            if(password.match(/[a-z]{4}/i)) intScore -= 5; // the password contains a chain of 4 alpha letters... decrease the strength

            // check out the ratio between alpha, numerical and special chars:
            var split = password.split(/\d/);
            var cnt_num = split.length-1;
            split = password.split(/\W/);
            var cnt_special = split.length-1;
            var cnt_alpha = password.length-cnt_alpha-cnt_special;
            var diff_alphanum = cnt_alpha-cnt_num;
            var diff_alphaspecial = cnt_alpha-cnt_special;
            if(diff_alphanum <= password.length/3 || diff_alphanum >= -password.length/3) intScore +=7;
            if(diff_alphaspecial <= password.length/3 || diff_alphaspecial >= -password.length/3) intScore +=7;

            // COMMON WORD
            for (var i=0; i < options.common.length; i++) {
                //check that the password doesn't contain a common word
                if (password.toLowerCase() == options.common[i]) intScore -= 300;  // El password es una palabra comun
                if (password.toLowerCase().indexOf(options.common[i]) >= 0) intScore -= 20; // el password forma parte de una palabra comun
            }
            console.log("Valor final: "+intScore);
            return intScore;
        }
    });
})(jQuery);
