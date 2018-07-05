<?php
/*
Plugin Name: Platypus - Divi Modules
Plugin URI: http://www.platypuslocal.com
Description: Platypus - Divi Modules
Author: Platypus
Version: 0.1
Author URI: http://www.platypuslocal.com/
*/

//require(get_template_directory()."/functions.php");
//require(get_template_directory()."/includes/builder/class-et-global-settings.php");
//require(get_template_directory()."/includes/builder/class-et-builder-element.php");

//get_template_part(); 
/*
class ET_Builder_Module_SCOTTT extends ET_Builder_Module {
        function init() {
                $this->name            = __( 'SCOTTT', 'et_builder' );
                $this->slug            = 'et_pb_scottt';

		$this->whitelisted_fields = array(
                        'background_layout',
                        'text_orientation',
                        'content_new',
                        'admin_label',
                        'module_id',
                        'module_class',
                        'max_width',
                );

                $this->fields_defaults = array(
                        'background_layout' => array( 'light' ),
                        'text_orientation'  => array( 'left' ),
                );
       	}

        function get_fields() {
                $fields = array(
                        'raw_content' => array(
                                'label'       => __( 'Content', 'et_builder' ),
                                'type'        => 'textarea',
                                'description' => __( 'Here you can create the content that will be used within the module.', 'et_builder' ),
                        ),
                        'admin_label' => array(
                                'label'       => __( 'Admin Label', 'et_builder' ),
                                'type'        => 'text',
                                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
                        ),
                        'module_id' => array(
                                'label'       => __( 'CSS ID', 'et_builder' ),
                                'type'        => 'text',
                                'description' => __( 'Enter an optional CSS ID to be used for this module. An ID can be used to create custom CSS styling, or to create links to particular sections of your page.', 'et_builder' ),
                        ),
                        'module_class' => array(
                                'label'       => __( 'CSS Class', 'et_builder' ),
                                'type'        => 'text',
                                'description' => __( 'Enter optional CSS classes to be used for this module. A CSS class can be used to create custom CSS styling. You can add multiple classes, separated with a space.', 'et_builder' ),
                        ),
                );

                return $fields;
        }

        function shortcode_callback( $atts, $content = null, $function_name ) {
                $module_id    = $this->shortcode_atts['module_id'];
                $module_class = $this->shortcode_atts['module_class'];

                $output = sprintf(
                        '<div%2$s class="et_pb_fullwidth_code et_pb_module%3$s">WHERE THE CODE IS
                                %1$s
                        </div> <!-- .et_pb_fullwidth_code -->',
                        $this->shortcode_content,
                        ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                        ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
                );

                return $output;
        }
}
new ET_Builder_Module_SCOTTT;
*/
?>
