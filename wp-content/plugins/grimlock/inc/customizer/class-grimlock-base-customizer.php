<?php
/**
 * Grimlock_Base_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The base class for managing the Customizer panels, sections and fields.
 */
abstract class Grimlock_Base_Customizer {
	/**
	 * @var string $section The name for the section in the Customizer.
	 * @since 1.0.0
	 */
	protected $section;

	/**
	 * @var string $title The title for the section in the Customizer.
	 * @since 1.0.0
	 */
	protected $title;

	/**
	 * @var array $defaults The array of Customizer fields defaults as key-value pairs.
	 *
	 * @since 1.0.0
	 */
	protected $defaults;

	/**
	 * Get a theme default value from key.
	 *
	 * @since 1.0.0
	 * @param $name
	 *
	 * @return mixed The value of the theme default.
	 */
	protected function get_default( $name ) {
		return isset( $this->defaults[$name] ) ? $this->defaults[$name] : false;
	}

	/**
	 * Wrapper function for `get_theme_mod` with automatically complete `$default` argument with
	 * theme default using `get_default` method.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/get_theme_mod
	 * @param $name
	 * @since 1.0.0
	 *
	 * @return mixed  The value of the theme mod or the theme default.
	 */
	protected function get_theme_mod( $name ) {
		return get_theme_mod( $name, $this->get_default( $name ) );
	}

	/**
	 * Register default values, settings and custom controls for the Theme Customizer.
	 *
	 * @since 1.0.0
	 */
	public abstract function add_customizer_fields();

	/**
	 * Add a Kirki section in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_section( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'panel'    => 'grimlock_appearance_customizer_panel',
				'title'    => $this->title,
				'priority' => 50,
			) );

			Kirki::add_section( $this->section, apply_filters( "{$this->section}_args", $args ) );
		}
	}

	/**
	 * Add a divider to enhance the readability for the Customizer section.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_divider_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'divider',
				'section'  => $this->section,
				'priority' => 10,
			) );
			$args['settings'] = "{$this->section}_divider_{$args['priority']}";

			Kirki::add_field( 'grimlock', apply_filters( "{$this->section}_divider_{$args['priority']}_args", $args ) );
		}
	}

	/**
	 * Add a heading for the Customizer section.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	public function add_heading_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$args = wp_parse_args( $args, array(
				'type'     => 'heading',
				'section'  => $this->section,
				'priority' => 10,
			) );
			$args['settings'] = "{$this->section}_heading_{$args['priority']}";

			Kirki::add_field( 'grimlock', apply_filters( "{$this->section}_heading_{$args['priority']}_args", $args ) );
		}
	}

	/**
	 * Convert CSS rules into JS Variables for the Customizer previews.
	 *
	 * @since 1.0.0
	 * @param  array $outputs The array of CSS rules.
	 *
	 * @return array          The array of JS Variables for the Customizer previews.
	 */
	protected function to_js_vars( $outputs ) {
		if ( ! is_array( $outputs ) ) {
			return array();
		}
		$js_vars = array();
		foreach ( $outputs as $output ) {
			$js_vars[] = array_merge( $output, array(
				'function' => 'style',
			) );
		}
		return $js_vars;
	}

	/**
	 * Get the css var output for a Kirki field from the name of the theme mod
	 *
	 * @since 1.2.6
	 * @param string $theme_mod The name of the theme mod
	 * @param string $units Units to use for this css var.
	 *
	 * @return array The css var output for the Kirki field
	 */
	protected function get_css_var_output( $theme_mod, $units = '' ) {
		if ( empty( $theme_mod ) ) {
			return array();
		}

		$css_var_output = array(
			'element'  => ':root',
			'property' => esc_html( str_replace( '_', '-', "--grimlock-{$theme_mod}" ) ),
		);

		if ( ! empty( $units ) ) {
			$css_var_output['units'] = esc_html( $units );
		}

		return $css_var_output;
	}
}
