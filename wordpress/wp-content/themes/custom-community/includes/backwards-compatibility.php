<?php
if( version_compare( $GLOBALS['wp_version'], '4.3', '<' ) ) {
	// WP Title
	function custom_community_wp_title( $title, $sep ) {
		if( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		$title .= get_bloginfo( 'name', 'display' );

		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		if ( ( $paged >= 2 || $page >= 2) && !is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'cc2' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'custom_community_wp_title', 10, 2 );

	// Render title
	function custom_community_render_title() { ?>
		<title><?php wp_title('|', true, 'right'); ?></title>
	<?php }
	add_action('wp_head', 'custom_community_render_title');
}