<?php

function swdSliders_admin_page_parametres_images(){
	
	$miniature_largeur = get_option('swd_sliders_thumbnail_size_w');
	$miniature_hauteur = get_option('swd_sliders_thumbnail_size_h');

	// Nom des variables des champs et options 
    $opt_name_miniature_l = 'swd_sliders_thumbnail_size_w';
	$opt_name_miniature_h = 'swd_sliders_thumbnail_size_h';

    $hidden_field_name = 'swd_submit_hidden';

    // Récupère les valeur dans la table wp_options de la BD
	$opt_val_miniature_l = get_option( $opt_name_miniature_l );
	$opt_val_miniature_h = get_option( $opt_name_miniature_h );
	
	// Vérifie si l'utilisateur a renseigné des paramètres
    // Si c'est le cas, ce champ caché sera mis à 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Initialise les variables avec les valeurs du formulaire
		$opt_val_miniature_l = $_POST[ $opt_name_miniature_l ];
		$opt_val_miniature_h = $_POST[ $opt_name_miniature_h ];
	
        // Sauvegarde les options dans la BD
        update_option( $opt_name_miniature_l, $opt_val_miniature_l );
		update_option( $opt_name_miniature_h, $opt_val_miniature_h );
		 
        // Affiche un message "paramètres enregistrés" 
		?>
		<div id="message" class="updated notice is-dismissible"><p><strong><?php _e('Settings saved.', 'diaporamas' ); ?></strong></p></div>
		<?php
	} ?>	
	
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	
	<div id="parametres-images">
		<table class="form-table">
			<tbody><tr>
				<th scope="row"><?php _e('Thumbnail size', 'diaporamas' ); ?></th>
				<td>
					<label for="swd_sliders_thumbnail_size_w"><?php _e('Width', 'diaporamas' ); ?></label><input name="swd_sliders_thumbnail_size_w" type="number" step="1" min="0" id="swd_sliders_thumbnail_size_w" value="<?php echo $opt_val_miniature_l; ?>" class="small-text">
					<label for="swd_sliders_thumbnail_size_h"><?php _e('Height', 'diaporamas' ); ?></label><input name="swd_sliders_thumbnail_size_h" type="number" step="1" min="0" id="swd_sliders_thumbnail_size_h" value="<?php echo $opt_val_miniature_h; ?>" class="small-text">
				</td>
			</tr></tbody>
		</table>
	</div>
	<?php
}
?>