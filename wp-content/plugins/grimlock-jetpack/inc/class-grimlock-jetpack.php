<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_Jetpack
 *
 * @author  octopix
 * @since   1.0.0
 * @package grimlock-jetpack/inc
 */
class Grimlock_Jetpack {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-jetpack', false, 'grimlock-jetpack/languages' );

		add_filter( 'grimlock_button_customizer_elements',         array( $this, 'add_elements'                       ), 10, 1 );
		add_filter( 'grimlock_button_customizer_primary_elements', array( $this, 'add_primary_elements'               ), 10, 1 );

		add_action( 'wp_enqueue_scripts',                          array( $this, 'wp_enqueue_scripts'                 ), 10    );
		add_action( 'wp_footer',                                   array( $this, 'change_infinite_scroll_button_text' ), 20    );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the button.
	 *
	 * @return array           The updated array of CSS selectors for the button.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'div#infinite-handle span',
		) );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the primary button.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the primary button.
	 *
	 * @return array           The updated array of CSS selectors for the primary button.
	 */
	public function add_primary_elements( $elements ) {
		return array_merge( $elements, array(
			'div#infinite-handle span',
		) );
	}

	/**
	 * Enqueue scripts and stylesheets.
	 *
	 * @since 1.0.0
	 */
	public function wp_enqueue_scripts() {
		if ( apply_filters( 'grimlock_jetpack_js_enqueued', is_home() || is_archive() || is_search() ) ) {
			wp_enqueue_script( 'grimlock-jetpack-infinite-scroll', GRIMLOCK_JETPACK_PLUGIN_DIR_URL . 'assets/js/infinite-scroll.js', array( 'jquery', 'jquery-masonry', 'imagesloaded' ), GRIMLOCK_JETPACK_VERSION, true );
		}
	}

	/**
	 * Change Jetpack Infinite Scroll module 'Older Posts' button text.
	 *
	 * @since 1.0.2
	 */
	public function change_infinite_scroll_button_text() {
		if ( is_home() || is_archive() || is_search() ) : ?>
			<script type="text/javascript">
                if ( typeof infiniteScroll !== 'undefined' ) {
                    //<![CDATA[
                    infiniteScroll.settings.text = '<?php echo esc_html__( 'Load more', 'grimlock-jetpack' ); ?>';
                    //]]>
                }
			</script>
		<?php
		endif;
	}
}
