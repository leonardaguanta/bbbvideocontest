(function($) {
    "use strict";


    var handle_conditional_logic = false;
    jQuery(document).bind('gform_post_render', function() {

        if (typeof mygf_form_ID !== "undefined" && typeof all_validations !== "undefined") {
            setTimeout(function() {
                
                for (var key in all_validations) {



                    if (hasSubFields.indexOf(all_validations[key].fieldType) == -1 && jQuery("#field_" + mygf_form_ID + "_" + key).length > 0 && !jQuery("#field_" + mygf_form_ID + "_" + key).is(":visible") && jQuery("#gform_wrapper_" + mygf_form_ID).is(":visible")) {

                        if (all_validations[key].fieldType == "radio") {    

                            var radios = document.getElementsByName('input_' + key);
                         
                            for (var i = 0; i < radios.length; i++) {
                                radios[i].disabled = true;
                            }
                            handle_conditional_logic = true;

                        } else {

                            all_validations[key].disable();

                            handle_conditional_logic = true;
                        }


                    }

                    if (hasSubFields.indexOf(all_validations[key].fieldType) !== -1 && jQuery("#input_" + mygf_form_ID + "_" + key).length > 0 && (!jQuery("#input_" + mygf_form_ID + "_" + key).is(":visible") && jQuery("#gform_wrapper_" + mygf_form_ID).is(":visible"))) {
                     
                        all_validations[key].disable();

                        handle_conditional_logic = true;
                    }
                }
                
                
                var defaualt_on_click = jQuery(".gform_previous_button:visible").attr("onclick");



                jQuery(".gform_previous_button").attr("onclick", " jQuery('#gform_" + mygf_form_ID + "').addClass('back_bt_press'); " + defaualt_on_click);
            }, 100);


        }
    });




    jQuery(document).bind('gform_post_conditional_logic', function(a, b, c, d) {
      
        if (typeof all_validations !== "undefined") {
            for (var key in all_validations) {
               
               
             if (jQuery("#field_" + mygf_form_ID + "_" + key).length > 0 && (!jQuery("#input_" + mygf_form_ID + "_" + key).is(":visible") && (jQuery("#gform_wrapper_" + mygf_form_ID).is(":visible")))) {
                   
                 
                    if (all_validations[key].fieldType == "radio") {
                        var radios = document.getElementsByName('input_' + key);
                        for (var i = 0; i < radios.length; i++) {
                            radios[i].disabled = true;
                        }
                        handle_conditional_logic = true;

                    } else {
                        all_validations[key].disable();

                        handle_conditional_logic = true;
                    }

                }
                else if(hasSubFields.indexOf(all_validations[key].fieldType) !== -1 && jQuery("#input_" + mygf_form_ID + "_" + key).length > 0 && !jQuery("#input_" + mygf_form_ID + "_" + key).is(":visible")){
                     
                    all_validations[key].disable();

                        handle_conditional_logic = true;
                }
                else {
                  
                    if (all_validations[key].fieldType == "radio") {
                     
                        var radios = document.getElementsByName('input_' + key);
                        for (var i = 0; i < radios.length; i++) {
                            radios[i].disabled = false;
                        }


                    } else {
                        all_validations[key].enable();
                    }


                }
            }
        }

    });






}(jQuery));

var hasSubFields = new Array("name", "date", "time", "address");


