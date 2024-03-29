<?php
/**
 * Grimlock_Table_Customizer Class
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
 * The Grimlock Customizer style class.
 */
class Grimlock_Table_Customizer extends Grimlock_Base_Customizer {
	/**
	 * @var array The array of elements to target the tables in theme.
	 * @since 1.0.0
	 */
	protected $elements;

	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->section = 'grimlock_table_customizer_section';
		$this->title   = esc_html__( 'Tables', 'grimlock' );

		add_action( 'after_setup_theme', array( $this, 'add_customizer_fields' ), 20 );
	}

	/**
	 * Register default values, settings and custom controls for the Theme Customizer.
	 *
	 * @since 1.0.0
	 */
	public function add_customizer_fields() {
		$this->defaults = apply_filters( 'grimlock_table_customizer_defaults', array(
			'table_border_width'             => GRIMLOCK_BORDER_WIDTH,
			'table_border_color'             => GRIMLOCK_BORDER_COLOR,
			'table_striped_background_color' => GRIMLOCK_GRAY_LIGHTEST,
		) );

		$this->elements = apply_filters( 'grimlock_table_customizer_elements', array(
			'table th',
			'table td',
			'table thead td',
			'table thead th',
			'.table th',
			'.table td',
			'.table thead td',
			'.table thead th',
			'.table-reflow tr th',
			'.table-reflow tr td',
			'.table-reflow th:last-child',
			'.table-reflow td:last-child',
			'.table-reflow thead:last-child tr:last-child th',
			'.table-reflow thead:last-child tr:last-child td',
			'.table-reflow tbody:last-child tr:last-child th',
			'.table-reflow tbody:last-child tr:last-child td',
			'.table-reflow tfoot:last-child tr:last-child th',
			'.table-reflow tfoot:last-child tr:last-child td',
			'.table-bordered',
		) );

		$this->add_section(                        array( 'priority' => 100 ) );

		$this->add_border_width_field(             array( 'priority' => 10  ) );
		$this->add_border_color_field(             array( 'priority' => 20  ) );
		$this->add_divider_field(                  array( 'priority' => 30  ) );
		$this->add_striped_background_color_field( array( 'priority' => 30  ) );
	}

	/**
	 * Add a Kirki color field to set the border color in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_border_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$elements = apply_filters( 'grimlock_table_customizer_border_color_elements', $this->elements );
			$outputs  = apply_filters( 'grimlock_table_customizer_border_color_outputs', array(
				$this->get_css_var_output( 'table_border_color' ),
				array(
					'element'  => implode( ',', $elements ),
					'property' => 'border-color',
				),
			), $elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Border Color', 'grimlock' ),
				'section'   => $this->section,
				'settings'  => 'table_border_color',
				'default'   => $this->get_default( 'table_border_color' ),
				'choices'   => array(
					'alpha'    => true,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'output'    => $outputs,
				'js_vars'   => $this->to_js_vars( $outputs ),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_table_customizer_border_color_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki slider control to set the border width in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_border_width_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$elements = apply_filters( 'grimlock_table_customizer_border_width_elements', $this->elements );
			$outputs  = apply_filters( 'grimlock_table_customizer_border_width_outputs', array(
				$this->get_css_var_output( 'table_border_width', 'px' ),
				array(
					'element'  => implode( ',', $elements ),
					'property' => 'border-width',
					'units'    => 'px',
				),
			), $elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'slider',
				'section'   => $this->section,
				'label'     => esc_attr__( 'Border Width', 'grimlock' ),
				'settings'  => 'table_border_width',
				'default'   => $this->get_default( 'table_border_width' ),
				'choices'   => array(
					'min'   => 0,
					'max'   => 10,
					'step'  => 1,
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'output'    => $outputs,
				'js_vars'   => $this->to_js_vars( $outputs ),
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_table_customizer_border_width_field_args', $args ) );
		}
	}

	/**
	 * Add a Kirki color field to set the alternative row color in the Customizer.
	 *
	 * @param array $args
	 * @since 1.0.0
	 */
	protected function add_striped_background_color_field( $args = array() ) {
		if ( class_exists( 'Kirki' ) ) {
			$elements = apply_filters( 'grimlock_table_customizer_striped_background_color_elements', array(
				'.table-striped tbody tr:nth-of-type(odd)',
				'.widget table tbody tr:nth-of-type(odd)',
				'.table-active',
				'.table-active > th',
				'.table-active > td',
				'.wpp-no-data',
			) );

			$outputs = apply_filters( 'grimlock_table_customizer_striped_background_color_outputs', array(
				$this->get_css_var_output( 'table_striped_background_color' ),
				array(
					'element'  => implode( ',', $elements ),
					'property' => 'background-color',
				),
			), $elements );

			$args = wp_parse_args( $args, array(
				'type'      => 'color',
				'label'     => esc_html__( 'Alternative Row Color', 'grimlock' ),
				'section'   => $this->section,
				'settings'  => 'table_striped_background_color',
				'default'   => $this->get_default( 'table_striped_background_color' ),
				'choices'   => array(
					'alpha'    => true,
					'palettes' => apply_filters( 'grimlock_color_field_palettes', array() ),
				),
				'priority'  => 10,
				'transport' => 'postMessage',
				'js_vars'   => $this->to_js_vars( $outputs ),
				'output'    => $outputs,
			) );

			Kirki::add_field( 'grimlock', apply_filters( 'grimlock_table_customizer_striped_background_color_field_args', $args ) );
		}
	}
}

return new Grimlock_Table_Customizer();
