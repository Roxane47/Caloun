<?php

require_once dirname( __FILE__ ) . '/swd-slider-parametres-general.php';
require_once dirname( __FILE__ ) . '/swd-slider-parametres-images.php';

/* Options
-----------------------------------------------------------------*/
add_action('admin_init', 'swdSliders_options');
function swdSliders_options() { 
    /* Front Page Options Section */
	add_settings_section( 
		'swdSliders_page_parametres_generaux',
		__( 'Location of Files', 'diaporamas' ),
		'swdSliders_options_general_callback_function',
		'swdSliders_options_general'
	);

	/* Header Options Section */
	add_settings_section( 
		'swdSliders_page_parametres_images',
		__( 'Thumbnail', 'diaporamas' ),
		'swdSliders_options_images_callback_function',
		'swdSliders_options_images'
	);

	register_setting('swdSliders_options_general', 'swdSliders_options_general');
	register_setting('swdSliders_options_images', 'swdSliders_options_images');
}


/* Call Backs
-----------------------------------------------------------------*/
function swdSliders_options_general_callback_function() { 
	swdSliders_admin_page_parametres_general();
}
function swdSliders_options_images_callback_function() { 
	swdSliders_admin_page_parametres_images();
}


/* Display Page
-----------------------------------------------------------------*/
function swdSliders_pages_parametres() {
	// On vérifie que l'utilisateur a la capacité requise
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.', 'diaporamas') );
    }
?>
    <div class="wrap">  
        <div class="dashicons-before dashicons-admin-settings"><br></div>
		<h1><?php _e( 'Parameters', 'diaporamas' ); ?></h1>
        <?php settings_errors(); ?>  

        <?php  
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';  
        ?>

        <h2 class="nav-tab-wrapper">  
            <a href="?post_type=sliders&page=parametres" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'diaporamas' ); ?></a>  
            <a href="?post_type=sliders&page=parametres&tab=images_options" class="nav-tab <?php echo $active_tab == 'images_options' ? 'nav-tab-active' : ''; ?>"><?php _e('Images', 'diaporamas' ); ?></a>
        </h2>  


        <!--<form method="post" action="options.php"> 
		<form name="formParametres" method="post" action="">-->
		<form method="post" action="">
            <?php
            if( $active_tab == 'general' ) {  
                settings_fields( 'swdSliders_options_general' );
                do_settings_sections( 'swdSliders_options_general' );
            } else if( $active_tab == 'images_options' ) {
                settings_fields( 'swdSliders_options_images' );
                do_settings_sections( 'swdSliders_options_images' ); 
            }
            ?>             
            <?php submit_button(); ?>  
        </form>

		<hr/>
		<p class="auteur"><?php _e('Developed By:', 'diaporamas'); ?> <a href="http://thierryfosse.net/" title="Thierry FOSSE" target="_blank">Thierry FOSSE</a></p>

		<p class="wp-feedback">
			<?php
			$lien = __('https://wordpress.org/plugins/diaporamas/', 'diaporamas');
			$notation = sprintf( __('You like this plugin? Write a review or some feed back <a href="%s">here</a>.', 'diaporamas'), $lien );
			echo $notation;
		?>
		</p>
		
		<p class="don">
			<p><?php _e('Buy me a coffee or support this plugin.', 'diaporamas'); ?></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="52HRF8SW5Z23G">
				<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
				<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
			</form>
		</p>
    </div> 
<?php
}