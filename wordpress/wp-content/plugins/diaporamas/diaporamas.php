<?php
/*
Plugin Name: Diaporamas
Plugin URI: http://succes-web.com
Description: Permet de gérer des diaporamas en plaçant un shortcode dans les pages de son choix.
Version: 1.3
Author: Succès-Web
Author URI: http://thierryfosse.com
License: GPL2
Text Domain: diaporamas
Domain Path: /lang
*/


/* SETUP */
define( 'SWDSLIDER_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SWDSLIDER_URL_ADMIN', trailingslashit( admin_url() ) );

require_once dirname( __FILE__ ) . '/swd-slider-init.php';
require_once dirname( __FILE__ ) . '/swd-slider-parametres.php';

add_action( 'plugins_loaded', 'swdSlider_setup' );


// GET ROTATORS
function swdSliders_diaporamas()
{
	$diaporamas = array();
	$diaporamas['homepage'] 		= array( 'size' => 'large' );
	$diaporamas['attachments'] 		= array( 'size' => 'large', 'hide_text_image' => true );
	
	// GET ROTATORS FROM sliders POST TYPE
	$sliders = get_posts( array( 'post_type' => 'sliders', 'posts_per_page' => -1 ) );
	if( $sliders )
	{
		foreach( $sliders as $slider )
		{
			// CUSTOM FIELDS
			$current_randomize				= (int) get_post_meta( $slider->ID, '_randomize', true );
			$current_slideshow_duration		= get_post_meta( $slider->ID, '_slideshow_duration', true );
			$current_animation_speed		= get_post_meta( $slider->ID, '_animation_speed', true );
			$current_animation				= get_post_meta( $slider->ID, '_animation', true );
			$current_animation_direction	= get_post_meta( $slider->ID, '_animation_direction', true );
			
			// CREATE NEW ARRAY IF NOT ALREADY, 
			// *** MANUALLY CREATING ROTATORS TAKES PRECEDENCE
			if( ! isset( $diaporamas[ $slider->post_name ] ) ) 
			{
				$diaporamas[ $slider->post_name ] = array();
			}
			
			// ADVANCED FLEXSLIDER OPTIONS
			$advanced_options = array();
			if( isset($diaporamas[ $slider->post_name ]['options']) )
			{
				$advanced_options = json_decode( $diaporamas[ $slider->post_name ]['options'], true );
			}
			
			if($current_randomize) 				{ $advanced_options['randomize'] = 'true'; }
			if($current_slideshow_duration) 	{ $advanced_options['slideshowSpeed'] = $current_slideshow_duration * 1000; }
			if($current_animation_speed) 		{ $advanced_options['animationSpeed'] = $current_animation_speed * 1000; }
			if($current_animation) 				{ $advanced_options['animation'] = $current_animation; }
			if($current_animation_direction) 	{ $advanced_options['direction'] = $current_animation_direction; }
			
			$diaporamas[ $slider->post_name ]['size'] 					= get_post_meta( $slider->ID, '_image_size', true );
			$diaporamas[ $slider->post_name ]['heading_tag'] 			= get_post_meta( $slider->ID, '_heading_tag', true );
			$diaporamas[ $slider->post_name ]['hide_text_image'] 		= get_post_meta( $slider->ID, '_hide_text_image', true );
			$diaporamas[ $slider->post_name ]['hide_nav_images'] 		= get_post_meta( $slider->ID, '_hide_nav_images', true );
			$diaporamas[ $slider->post_name ]['hide_list_puces_images'] = get_post_meta( $slider->ID, '_hide_list_puces_images', true );
			$diaporamas[ $slider->post_name ]['orderby']				= get_post_meta( $slider->ID, '_order_by', true );
			$diaporamas[ $slider->post_name ]['order']					= get_post_meta( $slider->ID, '_order', true );
			$diaporamas[ $slider->post_name ]['limit']					= (int) get_post_meta( $slider->ID, '_limit', true );
			$diaporamas[ $slider->post_name ]['style']					= get_post_meta( $slider->ID, '_style', true );
			$diaporamas[ $slider->post_name ]['cadre']					= get_post_meta( $slider->ID, '_cadre', true );
			$diaporamas[ $slider->post_name ]['forme']					= get_post_meta( $slider->ID, '_forme', true );
			$diaporamas[ $slider->post_name ]['fond']					= get_post_meta( $slider->ID, '_fond', true );
			$diaporamas[ $slider->post_name ]['background_color']		= get_post_meta( $slider->ID, '_background_color', true );
			$diaporamas[ $slider->post_name ]['cadre_color']			= get_post_meta( $slider->ID, '_cadre_color', true );
			
			$diaporamas[ $slider->post_name ]['options'] = json_encode($advanced_options);
		}
	}

	return apply_filters( 'swdSliders_diaporamas', $diaporamas );
}

// SETUP ACTIONS
function swdSlider_setup()
{
	if ( is_admin() ){
		add_action( 'init', 'swdSliders_init' );
		add_action( 'admin_head', 'swdSliders_admin_icon' );
		add_action( 'admin_enqueue_scripts', 'swdSliders_admin_css' );
		add_action( 'admin_enqueue_scripts', 'swdSliders_admin_script' );
				
		add_action( 'admin_notices', 'swdSliders_admin_notices' );
		
		add_action( 'add_meta_boxes', 'swdSliders_admin_metaboxes_nouvDiaporama' );
		add_action( 'add_meta_boxes', 'swdSliders_admin_metaboxes_nouvelleImage');
		
		add_action( 'save_post', 'swdSliders_save_meta', 1, 2 );
		
		add_filter( 'manage_edit-slides_columns', 'swdSliders_admin_images_definitColonnes' );
		add_action( 'manage_slides_posts_custom_column', 'swdSliders_admin_images_contenuColonnes' );
		
		
		add_filter( 'manage_edit-sliders_columns', 'swdSliders_admin_diaporamas_definitColonnes');
		add_action( 'manage_sliders_posts_custom_column', 'swdSliders_admin_diaporamas_contenuColonnes' );
		
		add_action( 'admin_menu', 'swdSliders_admin_sousmenu');
		
		add_filter( 'enter_title_here', 'swdSliders_adminPage_change_default_title' );
	}
	add_action( 'wp_enqueue_scripts', 'swdSliders_wp_enqueue' );
	add_shortcode( 'flexslider', 'swdSliders_shortcode' );
}


// NOTICE : Message d'infos
function swdSliders_admin_notices() {
	$init = get_option( 'swd_sliders_rep_upload_images' );
	$use = get_option( 'swd_sliders_use_media_settings' );
	if (strlen(trim( $init )) === 0 && $use == 0) {
		$lien = SWDSLIDER_URL_ADMIN ."edit.php?post_type=sliders&page=parametres";
		?><div id="message" class="updated notice is-dismissible"><p><?php _e('Diaporamas is not configured yet. ', 'diaporamas'); ?>
		<a href="<?php echo $lien; ?>"><?php _e('Click here', 'diaporamas'); ?></a><?php _e(' to adjust the settings.', 'diaporamas'); ?></p></div><?php
	}
}

// Administration du plugin
function swdSliders_admin_css() {
	wp_register_style( 'swd_admin_css', SWDSLIDER_URL . 'css/admin.css', false, '1.0.0' );
	wp_register_style( 'swd_jqueryFileTree_css', SWDSLIDER_URL . 'css/jqueryFileTree.css', false );
	wp_enqueue_style( 'swd_admin_css' );
	wp_enqueue_style( 'swd_jqueryFileTree_css' );
	wp_enqueue_style( 'wp-color-picker' );
}
function swdSliders_admin_script() {
	wp_register_script( 'swd_admin_js', SWDSLIDER_URL .'js/admin.js', false, '1.0.0' );
	wp_register_script( 'swd_jqueryFileTree_js', SWDSLIDER_URL .'js/jqueryFileTree.js', false, '1.0.1' );
	wp_enqueue_script( 'swd_admin_js' );
	wp_enqueue_script( 'swd_jqueryFileTree_js' );
	//wp_enqueue_script( 'my-script-handle', SWDSLIDER_URL .'js/jqueryColorPicker.js', array( 'wp-color-picker' ), false, true );
	wp_enqueue_script( 'my-script-handle', plugins_url('js/jqueryColorPicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


// FRONTEND : Heading CSS & JS
function swdSliders_wp_enqueue()//
{
	wp_enqueue_script( 'flexslider', SWDSLIDER_URL . 'js/jquery.flexslider-min.js', array( 'jquery' ) );
	wp_enqueue_style( 'flexslider', SWDSLIDER_URL . 'css/flexslider.css' );
}

// Icône du menu pour le Plugin
function swdSliders_admin_icon()//
{
	echo '
		<style> 
			#adminmenu #menu-posts-sliders div.wp-menu-image:before { content: "\f233"; }
		</style>
	';
}


// Rassemble les éléments d'un tableau
function swdSliders_implode_string( $arr )
{
	return "|" . implode("|", (array) $arr) . "|";
}
// Transforme une chaîne en tableau
function swdSliders_explode_string( $arr )
{
	return array_filter( explode("|", (string) $arr), 'strlen' );
}


// AFFICHE DIAPORAMA
function swdSliders_affiche_diaporama( $slug )
{
	// Récupère tous les diaporamas
	$diaporamas = swdSliders_diaporamas();

	$diaporama = $diaporamas[ $slug ];
				
	// Définit la taille de l'image : size
	$image_size = isset( $diaporama['size'] ) ? $diaporamas[ $slug ]['size'] : 'large';

	// Masque le texte des images : hide_text_image
	$hide_text_image = (isset( $diaporama['hide_text_image'] ) AND $diaporama['hide_text_image']) ? true : false;
	
	// Balise du Texte principal : heading_tag
	$header_type = isset( $diaporama['heading_tag'] ) ? $diaporama['heading_tag'] : "h2";
	
	// Tri selon les paramètres : orderby, order, limit
	$orderby = isset( $diaporama['orderby'] ) ? $diaporama['orderby'] : "menu_order";
	$order = isset( $diaporama['order'] ) ? $diaporama['order'] : "ASC";
	$limit = (isset( $diaporama['limit'] ) AND $diaporama['limit'] > 0) ? $diaporama['limit'] : "-1";
	
	// Paramètres par défaut
	$query_args = array( 'post_type' => 'slides', 'order' => $order, 'orderby' => $orderby, 'posts_per_page' => $limit);
	
	// Style CSS		
	$nocadre_css = (isset( $diaporama['cadre'] ) AND !$diaporama['cadre']) ? " noborder" : "";	// Encadrement de l'image
	$nobackground_css = (isset( $diaporama['fond'] ) AND !$diaporama['fond']) ? " nobackground" : "";	// Pas de fond
	
	if( isset( $diaporama['fond'] ) AND $diaporama['fond'] AND isset( $diaporama['background_color'] ) AND $diaporama['background_color'] )
	{
		$style_css = ' style="background-color: ' .$diaporama['background_color'] .';';		// Couleur de fond de l'image
	}
	else
	{
		$style_css = ' style="background-color: transparent;';
	}
	if( isset( $diaporama['cadre'] ) AND $diaporama['cadre'] AND isset( $diaporama['cadre_color'] ) AND $diaporama['cadre_color'] )
	{
		$style_css = $style_css .' border-color: ' .$diaporama['cadre_color'] .';';			// Couleur du cadre de l'image
	}
	$style_css = $style_css .'"';
	
	$forme_css = (isset( $diaporama['forme'] ) AND $diaporama['forme'] == "square") ? "square" : "rounded";	// Nav & Angle du cadre
		
	$styles_css = (isset( $diaporama['style'] ) AND $diaporama['style'] != "") ? $diaporama['style'] : "default";
	
	// Si $slug = attachments, il faut le post parent
	if( $slug == "attachments" )
	{
		$query_args['post_type'] = 'attachment';
		$query_args['post_parent'] = get_the_ID();
		$query_args['post_status'] = 'inherit';
		$query_args['post_mime_type'] = 'image';
		unset( $query_args['meta_value'] );
		unset( $query_args['meta_key'] );
	}
	else
	{
		$query_args['meta_query'] = array( 'relation' => 'OR',
		array(
			'key' 		=> '_slider_id',
			'value' 	=> $slug
		),
		array(
			'key' 		=> '_slider_id',
			'value' 	=> '|' . $slug . '|',
			'compare'	=> 'LIKE'
		));
	}
	$retour = "";
	
	// Masque les puces de navigation des images : hide_list_puces_images
	$hide_list_puces_images = (isset( $diaporama['hide_list_puces_images'] ) AND $diaporama['hide_list_puces_images']) ? true : false;
	$imagenav_css = ($hide_list_puces_images) ? " swd-slider-nolist" : "";	// Nav de la liste d'images
	
	// Masque les éléments de navigation des images : hide_nav_images
	$hide_nav_images = (isset( $diaporama['hide_nav_images'] ) AND $diaporama['hide_nav_images']) ? true : false;
	$imagenav_css .= ($hide_nav_images) ? " swd-slider-nonav" : "";	// Nav de la liste d'images	
	/*if ( $hide_nav_images )
	{
		$imagenav_css = 
	}*/
	
	query_posts( apply_filters( 'swd_slider_query_post_args', $query_args) );
/*echo '<pre>';
echo print_r($query_args);
echo '</pre>';	*/	
	if ( have_posts() ) 
	{
		$retour .= '<div id="swd_slider_' .$slug .'_wrapper" class="swd-slider-wrapper' .$imagenav_css .'">';
		$retour .= '<div id="swd_slider_' .$slug .'"' .$style_css .' class="swd_slider_' .$slug .' flexslider swd-slider swd-slider-corners-' .$forme_css . ' swd-slider-style-' . $styles_css .$nocadre_css .$nobackground_css .'">';
		$retour .= '<ul class="slides">';
		
		while ( have_posts() )
		{
			the_post();
	
			$url = esc_url( get_post_meta( get_the_ID(), "_slide_link_url", true ) );
			$a_balise = '<a href="' . $url . '" title="' . the_title_attribute( array('echo' => false) ) . '" >';

			$retour .= '<li>';
			$retour .= '<figure class="photo conception" itemprop="primaryImageOfPage" itemtype="http://schema.org/ImageObject">';
			
			if( $slug == "attachments" )
			{
				$retour .= wp_get_attachment_image( get_the_ID(), $image_size );
			}
			else if ( has_post_thumbnail() )
			{
				if($url) { $retour .= $a_balise; }
				$retour .= get_the_post_thumbnail( get_the_ID(), $image_size , array( 'class' => 'slide-thumbnail' ) );
				if($url) { $retour .= '</a>'; }
			}
			
			$titre = get_the_title();
			$text = get_the_excerpt();
			if( !$hide_text_image And (strlen($titre) + strlen($text)))
			{
				$retour .= '<figcaption><div class="slide-data" itemprop="description">';
				$retour .= '<' . $header_type . ' class="slide-title swd-slider-title">';
				
				if($url) { $retour .= $a_balise; }
				$retour .= get_the_title();
				if($url) { $retour .= '</a>'; }
				
				$retour .= '</' . $header_type . '>';
				
				$retour .= get_the_excerpt();
				$retour .= '</div></figcaption>';
			}
	
			$retour .= '</figure>';
			$retour .= '</li>';
		}
		

		// Début code HTML
		$slides = new WP_query("post_type=slides&posts_per_page=10");
		
		$retour .= '</ul>';
		$retour .= '</div><!-- close: #swd_slider_' . $slug . ' -->';
		$retour .= '</div><!-- close: #swd_slider_' . $slug . '_wrapper -->';
		
		// Initialise le Diaporama
		$retour .= '<script>';
		$retour .= " jQuery('#swd_slider_{$slug}').flexslider( ";
		
		if(isset($diaporamas[ $slug ]['options']) AND $diaporamas[ $slug ]['options'] != "") 
		{ 
			$retour .= $diaporamas[ $slug ]['options'];
		}
		
		$retour .= " ); ";
		$retour .= '</script>';		
	}
	wp_reset_postdata();
	wp_reset_query();
	
	return $retour;
}

// Sous-Menu Page Admin
function swdSliders_admin_sousmenu()
{
	// Ajoute des pages au menu du plugin
	add_submenu_page( 'edit.php?post_type=sliders', __('Add New Slide', 'diaporamas'), __('Add New Slide', 'diaporamas'), 'manage_options', 'post-new.php?post_type=slides' );
	add_submenu_page('edit.php?post_type=sliders', __('Parameters', 'diaporamas'), __('Parameters', 'diaporamas'), 'manage_options', 'parametres', 'swdSliders_pages_parametres');
}


//*************************************************
// Page Nouveau Diaporama

// META BOX Nouveau Diaporama
function swdSliders_admin_metaboxes_nouvDiaporama(){
    // Supprime les metabox extrait, attribut, image à la une
	remove_meta_box( 'postexcerpt' , 'sliders' , 'normal' );
	remove_meta_box( 'pageparentdiv' , 'sliders' , 'side' ); 
	remove_meta_box( 'postimagediv' , 'sliders' , 'side' ); 
	// Ajoute la metabox pour les paramètres du Nouveau Diaporama
	add_meta_box( 'swdSliders_admin_metabox_diaporama', __( 'Slider Settings', 'diaporamas' ), 'swdSliders_admin_metabox_diaporama', 'sliders', 'normal', 'default' );
}

// Contenu de la page Nouveau Diaporama
function swdSliders_admin_metabox_diaporama(){
	global $post;
	$current_limit					= (int) get_post_meta( $post->ID, '_limit', true );
	$current_image_size				= get_post_meta( $post->ID, '_image_size', true );
	$current_heading_tag			= get_post_meta( $post->ID, '_heading_tag', true );
	$current_order_by				= get_post_meta( $post->ID, '_order_by', true );
	$current_order					= get_post_meta( $post->ID, '_order', true );
	$current_hide_text_image		= get_post_meta( $post->ID, '_hide_text_image', true );
	$current_hide_nav_images		= get_post_meta( $post->ID, '_hide_nav_images', true );
	$current_hide_list_puces_images	= get_post_meta( $post->ID, '_hide_list_puces_images', true );
	$current_slideshow_duration		= get_post_meta( $post->ID, '_slideshow_duration', true );
	$current_animation_speed		= get_post_meta( $post->ID, '_animation_speed', true );
	$current_animation				= get_post_meta( $post->ID, '_animation', true );
	$current_animation_direction	= get_post_meta( $post->ID, '_animation_direction', true );
	$current_style					= get_post_meta( $post->ID, '_style', true );
	$current_cadre					= get_post_meta( $post->ID, '_cadre', true );
	$current_forme					= get_post_meta( $post->ID, '_forme', true );
	$current_fond					= get_post_meta( $post->ID, '_fond', true );
	$current_background_color		= get_post_meta( $post->ID, '_background_color', true );
	$current_cadre_color			= get_post_meta( $post->ID, '_cadre_color', true );
	
	// Initialisation des Variables
	if( !$current_animation ) $current_animation = "fade";
	if( !$current_animation_direction ) $current_animation_direction = "horizontal";
	if( !$current_order ) $current_order = "ASC";
	if( !$current_heading_tag ) $current_heading_tag = "h2";
	if( !$current_slideshow_duration ) $current_slideshow_duration = 8;
	if( !$current_animation_speed ) $current_animation_speed = 0.7;
	if( !$current_forme ) $current_forme = "square";
	if( !$current_style ) $current_style = "default";
	if( !$current_background_color ) $current_background_color = "#ccc";
	if( !$current_cadre_color ) $current_cadre_color = "#ccc";

	// DATA SETS
	$orderbys = array( 'date', 'id', 'title', 'name', 'modified', 'menu_order' );
	$slider_styles = array( 'default', 'slim', 'bottomheavy', 'crossed' ); 
	$image_sizes = get_intermediate_image_sizes();
?>
	
	<div class="hide_text_image">
		<input type="checkbox" name="hide_text_image" value="1" <?php if($current_hide_text_image) echo " CHECKED"; ?> onchange="if(this.checked) { jQuery('#heading-tag-p').fadeOut('2000'); } else { jQuery('#heading-tag-p').fadeIn('2000'); }" />
		&nbsp; <?php _e('Hide Images Title and Excerpt', 'diaporamas'); ?>
	</div>	

	<table class="form-table">
		<tbody>
		<tr>
			<th><label for="image_size"><?php _e('Image Size', 'diaporamas'); ?></label></th>
			<td>
				<select id="image_size" name="image_size">
					<?php foreach($image_sizes as $image_size) { ?>
					<option value="<?php echo $image_size ?>" <?php if($image_size == $current_image_size) echo " SELECTED"; ?>><?php echo $image_size ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="order_by"><?php _e('Order By', 'diaporamas'); ?></label></th>
			<td>
				<select id="order_by" name="order_by">
					<?php foreach($orderbys as $orderby) { ?>
					<option value="<?php echo $orderby ?>" <?php if($orderby == $current_order_by) echo " SELECTED"; ?>><?php echo $orderby ?></option>
					<?php } ?>
				</select>
				<span id="order_by-p">
					&nbsp; &nbsp;
					<input type="radio" name="order" value="ASC" <?php if($current_order == "ASC") echo " CHECKED"; ?> />
					<?php _e('Ascending', 'diaporamas'); ?>
					&nbsp; &nbsp;
					<input type="radio" name="order" value="DESC" <?php if($current_order == "DESC") echo " CHECKED"; ?> />
					<?php _e('Decending', 'diaporamas'); ?>
				</span>
			</td>
		</tr>
		<tr>
			<th><label for="animation"><?php _e('Animation', 'diaporamas'); ?></label></th>
			<td>
				<select id="animation" name="animation" onchange="if(this.value == 'fade') { jQuery('#animation-direction-p').slideUp(); } else { jQuery('#animation-direction-p').slideDown(); }">
					<option value="fade" <?php if("fade" == $current_animation) echo " SELECTED"; ?>><?php _e('Fade', 'diaporamas'); ?></option>
					<option value="slide" <?php if("slide" == $current_animation) echo " SELECTED"; ?>><?php _e('Slide', 'diaporamas'); ?></option>
				</select>
				<span id="animation-direction-p" <?php if($current_animation == "fade") echo "style='display:none;'"; ?>>
					&nbsp; &nbsp;
					<input type="radio" name="animation_direction" value="horizontal" <?php if($current_animation_direction == "horizontal") echo " CHECKED"; ?> />
					<?php _e('Horizontal', 'diaporamas'); ?>
					&nbsp; &nbsp;
					<input type="radio" name="animation_direction" value="vertical" <?php if($current_animation_direction == "vertical") echo " CHECKED"; ?> />
					<?php _e('Vertical', 'diaporamas'); ?>
				</span>
			</td>
		</tr>
		<tr>
			<th><label for="limit"><?php _e('Max number of Slides', 'diaporamas'); ?></label><br><span>(<?php _e('zero for all images', 'diaporamas'); ?>)</span></th>
			<td>
				<input type="text" style="width: 45px; text-align: center;" id="limit" name="limit" value="<?php echo esc_attr( $current_limit ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="slideshow_duration"><?php _e('Display time of each image (in seconds)', 'diaporamas'); ?></label></th>
			<td>
				<input type="text" style="width: 45px; text-align: center;" id="slideshow_duration" name="slideshow_duration" value="<?php echo esc_attr( $current_slideshow_duration ); ?>" />
			</td>
		</tr>
		<tr>
			<th><label for="animation_speed"><?php _e('Animation Speed (in seconds)', 'diaporamas'); ?></label></th>
			<td>
				<input type="text" style="width: 45px; text-align: center;" id="animation_speed" name="animation_speed" value="<?php echo esc_attr( $current_animation_speed ); ?>" />
			</td>
		</tr>
		<tr id="heading-tag-p" <?php if($current_hide_text_image) echo "style='display:none;'"; ?>>
			<th><label for="heading_tag"><?php _e('Title Tag', 'diaporamas'); ?></label></th>
			<td>
				<input type="text" style="width: 45px; text-align: center;" id="heading_tag" name="heading_tag" value="<?php echo esc_attr( $current_heading_tag ); ?>" />
			</td>
		</tr>
	</tbody></table>
	
	<div class="clear">
		<div class="frame-picture">
			<h3><?php _e('Framed Picture', 'diaporamas'); ?></h3>
			<p>
				<div class="left">
					<input type="checkbox" name="cadre" value="1" <?php if($current_cadre) echo " CHECKED"; ?> /> &nbsp; <?php _e('with frame', 'diaporamas'); ?>
				</div>
				<div>
					<input type="text" name="cadre_color" value="<?php echo esc_attr( $current_cadre_color ); ?>" class="input-color-picker" data-default-color="#ccc" />
					<br><br>
				</div>
				<div class="left">
					<input type="checkbox" name="fond" value="1" <?php if($current_fond) echo " CHECKED"; ?> /> &nbsp; <?php _e('With a background', 'diaporamas'); ?>
				</div>
				<div>
					<input type="text" name="background_color" value="<?php echo esc_attr( $current_background_color ); ?>" class="input-color-picker" data-default-color="#ccc" />
				</div>
			</p>
			<h3><?php _e('Elements Navigation', 'diaporamas'); ?></h3>
			<p>
				<input type="radio" name="forme" value="square" <?php if($current_forme == "square") echo " CHECKED"; ?> />
				<?php _e('Square', 'diaporamas'); ?>
				&nbsp; &nbsp;
				<input type="radio" name="forme" value="rounded" <?php if($current_forme == "rounded") echo " CHECKED"; ?> />
				<?php _e('Rounded', 'diaporamas'); ?>
			</p>
			<p>
				<input type="checkbox" name="hide_list_puces_images" value="1" <?php if($current_hide_list_puces_images) echo " CHECKED"; ?> />
				&nbsp; <?php _e('Hide fleas', 'diaporamas'); ?>
			</p>
			<p>
				<input type="checkbox" name="hide_nav_images" value="1" <?php if($current_hide_nav_images) echo " CHECKED"; ?> />
				&nbsp; <?php _e('Hide previous and next navigation elements', 'diaporamas'); ?>
			</p>
		</div>
		
		<div class="clear"></div>
	</div>
	<?php
}


//*************************************************
// Page Nouvelle Image

// META BOX Nouvelle Image
function swdSliders_admin_metaboxes_nouvelleImage(){
	// Supprime la metabox image à la une
	remove_meta_box( 'postimagediv' , 'slides' , 'side' );
	//on utilise la fonction add_metabox() pour initialiser une metabox
	// Ajoute la metabox Emplacement de l'image
	add_meta_box('swdSliders_admin_contenuMetabox_emplacement_nouvelleImage', __('Image Location', 'diaporamas'), 'swdSliders_admin_contenuMetabox_emplacement_nouvelleImage', 'slides', 'normal', 'high');
	// Ajoute la metabox Image à la une
	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'slides', 'normal');
	// Ajoute la metabox Paramètres de l'image
	add_meta_box('swdSliders_admin_contenuMetabox_parametres_nouvelleImage', __('Image Settings', 'diaporamas'), 'swdSliders_admin_contenuMetabox_parametres_nouvelleImage', 'slides', 'normal');
}

// Contenu de la metabox des paramètres de l'image de la page Nouvelle Image
function swdSliders_admin_contenuMetabox_parametres_nouvelleImage(){
	
	global $post;	
    $diaporamas = swdSliders_diaporamas();

	$slide_link_url 	= get_post_meta( $post->ID, '_slide_link_url', true );
	$slider_ids			= swdSliders_explode_string( get_post_meta( $post->ID, '_slider_id', true ) ); 
	
?>
	<p>
		<span class="description"><?php echo _e( 'A click on this slide is to link', 'diaporamas' ); ?></span><br>
		<input type="text" class="lien" name="slide_link_url" value="<?php echo esc_attr( $slide_link_url ); ?>" />
	</p>

	<p>
		<?php 
		if($diaporamas) { 
			_e('The picture is attached to Slideshow:', 'diaporamas'); ?> &nbsp; 
			
			<?php 
			foreach( $diaporamas as $diaporama => $size) 
			{ 	if( $diaporama == "attachments") continue; ?>
					<input type="checkbox" name="slider_id[]" <?php echo in_array($diaporama, $slider_ids) ? " CHECKED" : ""; ?> value="<?php echo $diaporama ?>"/> <?php echo $diaporama ?> &nbsp; &nbsp;
			<?php 
			} 
		} ?>
	</p>
	<?php
}

// Contenu de la page Nouvelle Image
function swdSliders_admin_contenuMetabox_emplacement_nouvelleImage(){
	
	global $post;
	$current_emplacement_image = get_post_meta( $post->ID, '_emplacement_image', true );
	
	if( !$current_emplacement_image ) $current_emplacement_image = "img_une";
	?>
	<label for="emplacement-image"><?php _e('Location', 'diaporamas'); ?></label>
	<!--<p id="emplacement-image" name="emplacement-image" onchange="if(this.value == 'lien') { jQuery('#lien-image-p').slideUp(); } else { jQuery('#lien-image-p').slideDown(); }">-->
	<p id="emplacement-image" name="emplacement-image">
		&nbsp; &nbsp;
		<input type="radio" name="emplacement-image" value="img_une" <?php if($current_emplacement_image == "img_une") echo " CHECKED"; ?> />
		<?php _e('Featured Image', 'diaporamas'); ?>
		&nbsp; &nbsp;
		<input type="radio" name="emplacement-image" value="lien" <?php if($current_emplacement_image == "lien") echo " CHECKED"; ?> disabled />
		<?php _e('Link (this option will be available in the next release)', 'diaporamas'); ?>
	</p>
	<?php
	// Ajoute la metabox image à la une
//	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'slides', 'normal', 'default');
	?>
	<p id="lien-image-p" <?php if($current_emplacement_image == "img_une") echo "style='display:none;'"; ?>>
		<label for="lien_image"><?php _e('Link', 'diaporamas'); ?></label>
		<span class="select-image">
			<input type="file" accept="image/*"  name="img" class="bouton" onchange="renseigneFichier(this.files)">
		</span>
		<input type="text" class="lien" id="lien_image" name="lien_image" />
	</p>
	
	<script>
		// validation du bouton 'Choisissez un fichier'
		function renseigneFichier(fichier) {	
			document.getElementById('lien_image').value = fichier[0].name;
		}
	</script>

	<?php
}
//*************************************************

// Sauvegarde les pages Diaporama et Image.
function swdSliders_save_meta( $post_id, $post )
{
	global $post;
	
	// Sauvegarde les données des diaporamas.
	if( isset( $_POST ) && isset( $post->ID ) && get_post_type( $post->ID ) == "sliders" ) 
	{
		if( isset($_POST['image_size']) ) 			update_post_meta( $post_id, '_image_size', strip_tags( $_POST['image_size'] ) );
		if( isset($_POST['heading_tag']) ) 			update_post_meta( $post_id, '_heading_tag', strip_tags( $_POST['heading_tag'] ) );
		if( isset($_POST['order_by']) ) 			update_post_meta( $post_id, '_order_by', strip_tags( $_POST['order_by'] ) );
		if( isset($_POST['order']) ) 				update_post_meta( $post_id, '_order', strip_tags( $_POST['order'] ) );
		if( isset($_POST['limit']) ) 				update_post_meta( $post_id, '_limit', (int) $_POST['limit'] );								
		if( isset($_POST['slideshow_duration']) ) 	update_post_meta( $post_id, '_slideshow_duration', strip_tags( $_POST['slideshow_duration'] ) );
		if( isset($_POST['animation_speed']) ) 		update_post_meta( $post_id, '_animation_speed', strip_tags( $_POST['animation_speed'] ) );

		if( isset($_POST['animation']) ) 			update_post_meta( $post_id, '_animation', strip_tags( $_POST['animation'] ) );
//console.log('Animation : ' .$_POST['animation']);			
		if( isset($_POST['animation_direction']) ) 	update_post_meta( $post_id, '_animation_direction', strip_tags( $_POST['animation_direction'] ) );
		if( isset($_POST['style']) ) 				update_post_meta( $post_id, '_style', strip_tags( $_POST['style'] ) );
		if( isset($_POST['forme']) ) 				update_post_meta( $post_id, '_forme', strip_tags( $_POST['forme'] ) );
													update_post_meta( $post_id, '_cadre', isset( $_POST['cadre'] ) ? 1 : 0 );
													update_post_meta( $post_id, '_hide_text_image', isset( $_POST['hide_text_image'] ) ? 1 : 0 );
													update_post_meta( $post_id, '_hide_nav_images', isset( $_POST['hide_nav_images'] ) ? 1 : 0 );
													update_post_meta( $post_id, '_hide_list_puces_images', isset( $_POST['hide_list_puces_images'] ) ? 1 : 0 );
													update_post_meta( $post_id, '_fond', isset( $_POST['fond'] ) ? 1 : 0 );
													update_post_meta( $post_id, '_background_color', strip_tags( $_POST['background_color'] ) );
													update_post_meta( $post_id, '_cadre_color', strip_tags( $_POST['cadre_color'] ) );
		return;
	}
	
	// Sauvegarde les données des images.
	if( isset( $_POST ) && isset( $post->ID ) && get_post_type( $post->ID ) == "slides" ) 
	{
		if( isset( $_POST['slide_link_url'] ) ) { update_post_meta( $post_id, '_slide_link_url', strip_tags( $_POST['slide_link_url'] ) ); }
		
		if ( isset( $_POST['slider_id'] ) ) 
		{
			if( is_array($_POST['slider_id']))
			{
				update_post_meta( $post_id, '_slider_id', swdSliders_implode_string($_POST['slider_id']) );
			}
			else
			{
				update_post_meta( $post_id, '_slider_id', strip_tags( $_POST['slider_id'] ) ); 
			}
		}
		else
		{
			update_post_meta( $post_id, '_slider_id', '' ); 
		}
		return;
	}
}

// Page Diaporamas
function swdSliders_admin_diaporamas_definitColonnes($columns)
{
	return array(
	    "cb" => "<input type=\"checkbox\" />",
	    "title" => __("Title", 'diaporamas'),
	    "slider_shortcode" => __("Shortcode", 'diaporamas')
	);  
}

function swdSliders_admin_diaporamas_contenuColonnes( $column )
{
	global $post;
	$edit_link = get_edit_post_link( $post->ID );

	if ( $column == 'slider_shortcode' ) 	echo '[flexslider slug="'.  $post->post_name .'"]';
}

// Page Images
function swdSliders_admin_images_definitColonnes( $columns ) 
{
	$columns = array(
		'cb'       => '<input type="checkbox" />',
		'image'    => __( 'Image', 'diaporamas' ),
		'title'    => __( 'Title', 'diaporamas' ),
		'ID'       => __( 'Slider', 'diaporamas' ),
		'order'    => __( 'Order', 'diaporamas' ),
		'link'     => __( 'Link', 'diaporamas' ),
		'date'     => __( 'Date', 'diaporamas' )
	);

	return $columns;
}

function swdSliders_admin_images_contenuColonnes( $column )
{
	global $post;
	$edit_link = get_edit_post_link( $post->ID );
$thumb_diapo_w = get_option('swd_sliders_thumbnail_size_w');
$thumb_diapo_h = get_option('swd_sliders_thumbnail_size_h');

	
	$slider_ids = swdSliders_explode_string( get_post_meta( $post->ID, "_slider_id", true ) );
	$slider_title_array = array();
	foreach($slider_ids as $slider_id) { $slider_title_array[] = $slider_id; }

	if ( $column == 'image' ) 	echo '<a href="' . $edit_link . '" title="' . $post->post_title . '">' 
	.get_the_post_thumbnail( $post->ID, 'minidiapo', array( 'title' => trim( strip_tags(  $post->post_title ) ) ) ) . '</a>';
	if ( $column == 'order' ) 	echo '<a href="' . $edit_link . '">' . $post->menu_order . '</a>';
	if ( $column == 'ID' ) 		echo implode(", ", $slider_title_array);
	if ( $column == 'link' ) 	echo '<a href="' . get_post_meta( $post->ID, "_slide_link_url", true ) . '" target="_blank" >' . get_post_meta( $post->ID, "_slide_link_url", true ) . '</a>';		
}


function swdSliders_adminPage_change_default_title( $title ){
    $screen = get_current_screen();

    if  ( $screen->post_type == 'sliders' ) {
        $title = __('Slider Name', 'diaporamas');
    } elseif ( $screen->post_type == 'slides' ) {
        $title = __('Image Name (optional)', 'diaporamas');
	}
	
    return $title;
}

// SHORTCODE
function swdSliders_shortcode($atts, $content = null)
{
	$slug = isset($atts['slug']) ? $atts['slug'] : "attachments";
	if(!$slug) { return apply_filters( 'swdSliders_empty_shortcode', "<p>__(Flexslider: Please include a 'slug' parameter. [flexslider slug=homepage], 'diaporamas')</p>" ); }
	return swdSliders_affiche_diaporama( $slug );
}


// Ajoute un lien à la Page du Plugin
function swdSliders_plugin_links_add( $lien, $file ) 
{
	$lien_don = '<a href="http://thierryfosse.com/donate" target="_blank">' . esc_html__( 'Donate', 'diaporamas' ) . '</a>';
	if ( $file == 'swd-slider/swd-slider.php' )
	{
		array_unshift( $lien, $lien_don );
	}
	return $lien;
}
add_filter( 'plugin_action_links', 'swdSliders_plugin_links_add', 10, 2 );