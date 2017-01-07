<?php

$upload_dir = wp_upload_dir();
define( 'REP_UPLOADS', $upload_dir['baseurl'].'/' );
define( 'SWDSLIDER_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

//wp_enqueue_style( 'swd_jqueryFileTree_css' );

wp_enqueue_script( 'jquery' );
//wp_enqueue_script( 'swd_jqueryFileTree_js' );

function swdSliders_admin_page_parametres_general(){
		
	global $post;
	global $select_options; 
	
	//if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false;
	
	$current_emplacement = get_option('swd_sliders_racine_upload_images');
	$use_media_settings = get_option('swd_sliders_use_media_settings');

	if( !$current_emplacement ) $current_emplacement = "Media";

	// Nom des variables des champs et options 
    $opt_name_racine = 'swd_sliders_racine_upload_images';
	$opt_name_rep = 'swd_sliders_rep_upload_images';
	$opt_name_mediawp = 'swd_sliders_use_media_settings';
	$opt_name_mediawp_moisan = 'uploads_use_yearmonth_folders';
    $hidden_field_name = 'swd_submit_hidden';

    // Récupère les valeur dans la table wp_options de la BD
	$opt_val_racine = get_option( $opt_name_racine );
	$opt_val_rep = get_option( $opt_name_rep );

    // Vérifie si l'utilisateur a renseigné des paramètres
    // Si c'est le cas, ce champ caché sera mis à 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Initialise les variables avec les valeurs du formulaire
		$opt_val_racine = $_POST[ $opt_name_racine ];
		$opt_val_rep = $_POST[ $opt_name_rep ];
		$opt_val_mediawp = $_POST[ $opt_name_mediawp ];
		$opt_val_mediawp_moisan = $_POST[ $opt_name_mediawp_moisan ];
	
        // Sauvegarde les options dans la BD
        update_option( $opt_name_racine, $opt_val_racine );
		update_option( $opt_name_rep, $opt_val_rep );
		update_option( $opt_name_mediawp, $opt_val_mediawp );
		update_option( $opt_name_mediawp_moisan, $opt_val_mediawp_moisan );
		 
        // Affiche un message "paramètres enregistrés" 
		?>
		<div id="message" class="updated notice is-dismissible"><p><strong><?php _e('Settings saved.', 'diaporamas' ); ?></strong></p></div>
		<?php
		$use_media_settings = get_option('swd_sliders_use_media_settings');		
	} ?>	
		
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	
	<div id="swdSliders-parametres">
		<div class="manage-menus">
			<?php _e( "This plugin allows you to select the location or recorded images will be added to your different slideshows.", 'diaporamas' ); ?>
			<p>
				<label for="swd_sliders_use_media_settings">
					<input name="swd_sliders_use_media_settings" type="checkbox" id="swd_sliders_use_media_settings" value="1" <?php checked('1', get_option('swd_sliders_use_media_settings')); ?> />
					<?php _e('Organize my files sent as Wordpress Media settings', 'diaporamas'); ?>
				</label>
			</p>
		</div>
				
		<div id="parametre_wp_media" <?php if(!$use_media_settings) echo 'style="display: none;"'; ?>>
			<label for="uploads_use_yearmonth_folders">
				<input name="uploads_use_yearmonth_folders" type="checkbox" id="uploads_use_yearmonth_folders" value="1"<?php checked('1', get_option('uploads_use_yearmonth_folders')); ?> />
				<?php _e('Organize my uploads into month- and year-based folders'); ?>
			</label>

		</div>
	</div>

	<?php
}
?>