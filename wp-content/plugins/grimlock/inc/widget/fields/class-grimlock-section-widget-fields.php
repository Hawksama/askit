<?php

/**
 * Grimlock_Section_Widget_Fields Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package  grimlock
 */
class Grimlock_Section_Widget_Fields extends Grimlock_Base_Widget_Fields {

	/**
	 * Setup class
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $id_base = 'grimlock_section_widget' ) {
		parent::__construct( $id_base );

		add_filter( "{$this->id_base}_tabs",        array( $this, 'change_tabs'                   ), 10, 1 );

		// General tab
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_thumbnail_field'           ), 100, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_title_field'               ), 110, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_subtitle_field'            ), 120, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_text_field'                ), 130, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_text_wpautoped_field'      ), 140, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_button_text_field'         ), 150, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_button_link_field'         ), 160, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_button_target_blank_field' ), 170, 2 );
		add_action( "{$this->id_base}_general_tab", array( $this, 'add_button_displayed_field'    ), 180, 2 );

		// Layout tab
		add_action( "{$this->id_base}_layout_tab",  array( $this, 'add_layout_field'              ), 100, 2 );
		add_action( "{$this->id_base}_layout_tab",  array( $this, 'add_container_layout_field'    ), 110, 2 );

		// Style tab fields
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_background_image_field'    ), 100, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_padding_y_field'           ), 110, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_background_color_field'    ), 120, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_border_top_width_field'    ), 130, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_border_top_color_field'    ), 140, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_border_bottom_width_field' ), 150, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_border_bottom_color_field' ), 160, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_title_format_field'        ), 170, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_title_color_field'         ), 180, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_subtitle_format_field'     ), 190, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_subtitle_color_field'      ), 200, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_color_field'               ), 210, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_button_format_field'       ), 220, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_button_size_field'         ), 230, 2 );
		add_action( "{$this->id_base}_style_tab",   array( $this, 'add_classes_field'             ), 240, 2 );
	}

	/**
	 * Change the list of tabs in the widget
	 *
	 * @param array $tabs The array containing the current tabs
	 *
	 * return array The new array of tabs
	 */
	public function change_tabs( $tabs ) {
		return array_merge( $tabs, array(
			'general' => esc_html__( 'General', 'grimlock' ),
			'layout'  => esc_html__( 'Layout',  'grimlock' ),
			'style'   => esc_html__( 'Style',   'grimlock' ),
		) );
	}

	/**
	 * Add an image field to set the featured image of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_thumbnail_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'thumbnail' ),
			'name'  => $widget->get_field_name( 'thumbnail' ),
			'label' => esc_html__( 'Featured Image:', 'grimlock' ),
			'value' => $instance['thumbnail'],
		);

		$this->image( apply_filters( "{$this->id_base}_thumbnail_field_args", $args, $instance ) );
	}

	/**
	 * Add a text field to set the title of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_title_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'title' ),
			'name'  => $widget->get_field_name( 'title' ),
			'label' => esc_html__( 'Title:', 'grimlock' ),
			'value' => html_entity_decode( $instance['title'] ),
		);

		$this->textfield( apply_filters( "{$this->id_base}_title_field_args", $args, $instance ) );
	}

	/**
	 * Add a text field to set the subtitle of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_subtitle_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'subtitle' ),
			'name'  => $widget->get_field_name( 'subtitle' ),
			'label' => esc_html__( 'Subtitle:', 'grimlock' ),
			'value' => html_entity_decode( $instance['subtitle'] ),
		);

		$this->textfield( apply_filters( "{$this->id_base}_subtitle_field_args", $args, $instance ) );
	}


	/**
	 * Add a text area to set the text of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_text_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'text' ),
			'name'  => $widget->get_field_name( 'text' ),
			'label' => esc_html__( 'Text:', 'grimlock' ),
			'value' => html_entity_decode( $instance['text'] ),
		);

		$this->textarea( apply_filters( "{$this->id_base}_text_field_args", $args, $instance ) );
	}

	/**
	 * Add a checkbox to set whether new paragraphs are automatically added in the text of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_text_wpautoped_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'text_wpautoped' ),
			'name'  => $widget->get_field_name( 'text_wpautoped' ),
			'label' => esc_html__( 'Automatically add paragraphs', 'grimlock' ),
			'value' => $instance['text_wpautoped'],
		);

		$this->checkbox( apply_filters( "{$this->id_base}_text_wpautoped_field_args", $args, $instance ) );
	}

	/**
	 * Add a text field to set the button text of the button in the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_text_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'button_text' ),
			'name'  => $widget->get_field_name( 'button_text' ),
			'label' => esc_html__( 'Button Text:', 'grimlock' ),
			'value' => html_entity_decode( $instance['button_text'] ),
		);

		$this->textfield( apply_filters( "{$this->id_base}_button_text_field_args", $args, $instance ) );
	}

	/**
	 * Add a text field to set the button text of the button in the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_link_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'button_link' ),
			'name'  => $widget->get_field_name( 'button_link' ),
			'label' => esc_html__( 'Button Link:', 'grimlock' ),
			'value' => $instance['button_link'],
		);

		$this->textfield( apply_filters( "{$this->id_base}_button_link_field_args", $args, $instance ) );
	}

	/**
	 * Add a checkbox to set whether the button link should open in a new page
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_target_blank_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'button_target_blank' ),
			'name'  => $widget->get_field_name( 'button_target_blank' ),
			'label' => esc_html__( 'Open link in a new page', 'grimlock' ),
			'value' => $instance['button_target_blank'],
		);

		$this->checkbox( apply_filters( "{$this->id_base}_button_target_blank_field_args", $args, $instance ) );
	}

	/**
	 * Add a checkbox to set whether the button is displayed in the widget
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_displayed_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'button_displayed' ),
			'name'  => $widget->get_field_name( 'button_displayed' ),
			'label' => esc_html__( 'Display button', 'grimlock' ),
			'value' => $instance['button_displayed'],
		);

		$this->checkbox( apply_filters( "{$this->id_base}_button_displayed_field_args", $args, $instance ) );
	}

	/**
	 * Add a radio image field to set the layout of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_layout_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'layout' ),
			'name'    => $widget->get_field_name( 'layout' ),
			'label'   => esc_html__( 'Layout:', 'grimlock' ),
			'value'   => $instance['layout'],
			'choices' => array(
				'12-cols-left'                 => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-12-cols-left.png',
				'12-cols-center'               => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-12-cols-center.png',
				'12-cols-right'                => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-12-cols-right.png',
				'6-6-cols-left'                => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-6-6-cols-left.png',
				'6-6-cols-left-reverse'        => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-6-6-cols-left-reverse.png',
				'4-8-cols-left'                => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-4-8-cols-left.png',
				'4-8-cols-left-reverse'        => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-4-8-cols-left-reverse.png',
				'6-6-cols-left-modern'         => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-6-6-cols-left-modern.png',
				'6-6-cols-left-reverse-modern' => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-6-6-cols-left-reverse-modern.png',
				'8-4-cols-left-modern'         => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-8-4-cols-left-modern.png',
				'8-4-cols-left-reverse-modern' => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/section-8-4-cols-left-reverse-modern.png',
			),
		);

		$this->radio_image( apply_filters( "{$this->id_base}_layout_field_args", $args, $instance ) );
	}

	/**
	 * Add an radio image field to set the spread of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_container_layout_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'container_layout' ),
			'name'    => $widget->get_field_name( 'container_layout' ),
			'label'   => esc_html__( 'Spread:', 'grimlock' ),
			'value'   => $instance['container_layout'],
			'choices' => array(
				'classic'  => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/region-container-classic.png',
				'fluid'    => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/region-container-fluid.png',
				'narrow'   => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/region-container-narrow.png',
				'narrower' => GRIMLOCK_PLUGIN_DIR_URL . 'assets/images/region-container-narrower.png',
			),
		);

		$this->radio_image( apply_filters( "{$this->id_base}_container_layout_field_args", $args, $instance ) );
	}

	/**
	 * Add an image field to set the background image of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_background_image_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'background_image' ),
			'name'  => $widget->get_field_name( 'background_image' ),
			'label' => esc_html__( 'Background Image:', 'grimlock' ),
			'value' => $instance['background_image'],
		);

		$this->image( apply_filters( "{$this->id_base}_background_image_field_args", $args, $instance ) );
	}

	/**
	 * Add a range field to set the vertical padding of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0
	 */
	public function add_padding_y_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'padding_y' ),
			'name'  => $widget->get_field_name( 'padding_y' ),
			'min'   => 0,
			'max'   => 25,
			'label' => esc_html__( 'Vertical Padding:', 'grimlock' ),
			'value' => $instance['padding_y'],
		);

		$this->range( apply_filters( "{$this->id_base}_padding_y_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the background color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_background_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'background_color' ),
			'name'  => $widget->get_field_name( 'background_color' ),
			'label' => esc_html__( 'Background Color:', 'grimlock' ),
			'value' => $instance['background_color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_background_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a range field to set the border top width of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0
	 */
	public function add_border_top_width_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'border_top_width' ),
			'name'  => $widget->get_field_name( 'border_top_width' ),
			'min'   => 0,
			'max'   => 25,
			'step'  => 1,
			'label' => esc_html__( 'Border Top Width:', 'grimlock' ),
			'value' => $instance['border_top_width'],
		);

		$this->range( apply_filters( "{$this->id_base}_border_top_width_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the top border color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_border_top_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'border_top_color' ),
			'name'  => $widget->get_field_name( 'border_top_color' ),
			'label' => esc_html__( 'Border Top Color:', 'grimlock' ),
			'value' => $instance['border_top_color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_border_top_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a range field to set the border bottom width of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0
	 */
	public function add_border_bottom_width_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'border_bottom_width' ),
			'name'  => $widget->get_field_name( 'border_bottom_width' ),
			'min'   => 0,
			'max'   => 25,
			'step'  => 1,
			'label' => esc_html__( 'Border Bottom Width:', 'grimlock' ),
			'value' => $instance['border_bottom_width'],
		);

		$this->range( apply_filters( "{$this->id_base}_border_bottom_width_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the bottom border color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_border_bottom_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'border_bottom_color' ),
			'name'  => $widget->get_field_name( 'border_bottom_color' ),
			'label' => esc_html__( 'Border Bottom Color:', 'grimlock' ),
			'value' => $instance['border_bottom_color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_border_bottom_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a select to set the title format for the Section Component.
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_title_format_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'title_format' ),
			'name'  => $widget->get_field_name( 'title_format' ),
			'label'   => esc_html__( 'Title Format:', 'grimlock' ),
			'value'   => $instance['title_format'],
			'choices' => array(
				'display-1' => esc_html__( 'Heading 1', 'grimlock' ),
				'display-2' => esc_html__( 'Heading 2', 'grimlock' ),
				'display-3' => esc_html__( 'Heading 3', 'grimlock' ),
				'display-4' => esc_html__( 'Heading 4', 'grimlock' ),
				'lead'      => esc_html__( 'Subheading', 'grimlock' ),
			),
		);

		$this->select( apply_filters( "{$this->id_base}_title_format_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the title color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_title_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'title_color' ),
			'name'  => $widget->get_field_name( 'title_color' ),
			'label' => esc_html__( 'Title Color:', 'grimlock' ),
			'value' => $instance['title_color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_title_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a select to set the subtitle format for the Section Component.
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_subtitle_format_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'subtitle_format' ),
			'name'  => $widget->get_field_name( 'subtitle_format' ),
			'label'   => esc_html__( 'Subtitle Format:', 'grimlock' ),
			'value'   => $instance['subtitle_format'],
			'choices' => array(
				'display-1' => esc_html__( 'Heading 1', 'grimlock' ),
				'display-2' => esc_html__( 'Heading 2', 'grimlock' ),
				'display-3' => esc_html__( 'Heading 3', 'grimlock' ),
				'display-4' => esc_html__( 'Heading 4', 'grimlock' ),
				'lead'      => esc_html__( 'Subheading', 'grimlock' ),
			),
		);

		$this->select( apply_filters( "{$this->id_base}_subtitle_format_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the subtitle color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_subtitle_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'subtitle_color' ),
			'name'  => $widget->get_field_name( 'subtitle_color' ),
			'label' => esc_html__( 'Subtitle Color:', 'grimlock' ),
			'value' => $instance['subtitle_color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_subtitle_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a color picker to set the text color of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_color_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'color' ),
			'name'  => $widget->get_field_name( 'color' ),
			'label' => esc_html__( 'Text Color:', 'grimlock' ),
			'value' => $instance['color'],
		);

		$this->color_picker( apply_filters( "{$this->id_base}_color_field_args", $args, $instance ) );
	}

	/**
	 * Add a select to set the button format for the button of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_format_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'button_format' ),
			'name'  => $widget->get_field_name( 'button_format' ),
			'label'   => esc_html__( 'Button Format:', 'grimlock' ),
			'value'   => $instance['button_format'],
			'choices' => array(
				'btn-primary'   => esc_html__( 'Primary', 'grimlock' ),
				'btn-secondary' => esc_html__( 'Secondary', 'grimlock' ),
				'btn-link'      => esc_html__( 'Link', 'grimlock' ),
			),
		);

		$this->select( apply_filters( "{$this->id_base}_button_format_field_args", $args, $instance ) );
	}

	/**
	 * Add a select to set the button size for the button of the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_button_size_field( $instance, $widget ) {
		$args = array(
			'id'      => $widget->get_field_id( 'button_size' ),
			'name'  => $widget->get_field_name( 'button_size' ),
			'label'   => esc_html__( 'Button Size:', 'grimlock' ),
			'value'   => $instance['button_size'],
			'choices' => array(
				'btn-sm'    => esc_html__( 'Small',      'grimlock' ),
				''          => esc_html__( 'Regular',    'grimlock' ),
				'btn-lg'    => esc_html__( 'Large',      'grimlock' ),
				'btn-block' => esc_html__( 'Full Width', 'grimlock' ),
			),
		);

		$this->select( apply_filters( "{$this->id_base}_button_size_field_args", $args, $instance ) );
	}

	/**
	 * Add a text field to add additional CSS classes on the section
	 *
	 * @param array $instance
	 * @param WP_Widget $widget
	 * @since 1.0.0
	 */
	public function add_classes_field( $instance, $widget ) {
		$args = array(
			'id'    => $widget->get_field_id( 'classes' ),
			'name'  => $widget->get_field_name( 'classes' ),
			'label' => esc_html__( 'CSS Classes (optional):', 'grimlock' ),
			'value' => $instance['classes'],
		);

		$this->textfield( apply_filters( "{$this->id_base}_classes_field_args", $args, $instance ) );
	}

	/**
	 * Change the default settings for the widget
	 *
	 * @param array $defaults The default settings for the widget.
	 *
	 * @return array The updated default settings for the widget.
	 */
	public function change_defaults( $defaults ) {
		return array_merge( $defaults, array(
			'classes'             => '',

			'padding_y'           => GRIMLOCK_SECTION_PADDING_Y, // %

			'background_image'    => 0,
			'background_color'    => GRIMLOCK_SECTION_BACKGROUND_COLOR,

			'thumbnail'           => 0,

			'border_top_color'    => GRIMLOCK_BORDER_COLOR,
			'border_top_width'    => 0, // px
			'border_bottom_color' => GRIMLOCK_BORDER_COLOR,
			'border_bottom_width' => 0, // px

			'title'               => esc_html__( 'Title goes here...', 'grimlock' ),
			'title_color'         => '',
			'title_format'        => 'display-3',

			'subtitle'            => esc_html__( 'Subtitle goes here...', 'grimlock' ),
			'subtitle_color'      => '',
			'subtitle_format'     => 'lead',

			'text'                => esc_html__( 'Text goes here...', 'grimlock' ),
			'color'               => '',
			'text_wpautoped'      => true,

			'button_text'         => esc_html__( 'Learn more', 'grimlock' ),
			'button_link'         => '#',
			'button_target_blank' => false,
			'button_displayed'    => true,
			'button_format'       => 'btn-primary',
			'button_size'         => '',

			'layout'              => '12-cols-center',
			'container_layout'    => 'classic',
		) );
	}

	/**
	 * Change the arguments sent to the component in charge of rendering the widget
	 *
	 * @param array $component_args The arguments for the component in charge of rendering the widget
	 * @param array $instance Settings for the current widget instance.
	 * @param array $widget_args Display arguments including 'before_title', 'after_title',
	 *                           'before_widget', and 'after_widget'.
	 *
	 * @return array The updated arguments for the component in charge of rendering the widget
	 */
	public function change_component_args( $component_args, $instance, $widget_args, $widget_id ) {
		return array_merge( $component_args, array(
			'class'               => $this->get_classes( $instance ),

			'padding_top'         => $instance['padding_y'],
			'padding_bottom'      => $instance['padding_y'],

			'background_image'    => $this->get_background_image_url( $instance ),
			'background_color'    => $instance['background_color'],

			'thumbnail'           => $this->get_thumbnail_url( $instance ),
			'thumbnail_alt'       => $this->get_thumbnail_alt( $instance ),
			'thumbnail_caption'   => $this->get_thumbnail_caption( $instance ),

			'border_top_color'    => $instance['border_top_color'],
			'border_top_width'    => $instance['border_top_width'],
			'border_bottom_color' => $instance['border_bottom_color'],
			'border_bottom_width' => $instance['border_bottom_width'],

			'title'               => $widget_args['before_title'] . $instance['title'] . $widget_args['after_title'],
			'title_color'         => $instance['title_color'],
			'title_format'        => $instance['title_format'],
			'title_displayed'     => ! empty( $instance['title'] ),

			'subtitle'            => $instance['subtitle'],
			'subtitle_color'      => $instance['subtitle_color'],
			'subtitle_format'     => $instance['subtitle_format'],
			'subtitle_displayed'  => ! empty( $instance['subtitle'] ),

			'text'                => $instance['text'],
			'text_wpautoped'      => ! empty( $instance['text_wpautoped'] ),
			'color'               => $instance['color'],
			'text_displayed'      => ! empty( $instance['text'] ),

			'button_text'         => $instance['button_text'],
			'button_link'         => $instance['button_link'],
			'button_target_blank' => ! empty( $instance['button_target_blank'] ),
			'button_displayed'    => ! empty( $instance['button_displayed'] ),
			'button_format'       => $instance['button_format'],
			'button_size'         => $instance['button_size'],

			'layout'              => $instance['layout'],
			'container_layout'    => $instance['container_layout'],
		) );
	}

	/**
	 * Handles sanitizing settings for the current widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function sanitize_instance( $new_instance, $old_instance ) {
		$instance = $new_instance;

		$classes = isset( $new_instance['classes'] ) ? explode( ' ', str_replace( ',', ' ', $new_instance['classes'] ) ) : array();
		for( $i = 0; $i < count( $classes ); $i++ ) {
			$classes[$i] = sanitize_html_class( $classes[$i] );
		}
		$instance['classes'] = implode( ' ', $classes );

		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = isset( $new_instance['text'] ) ? $this->sanitize_text( $new_instance['text'], true ) : '';
		} else {
			$instance['text'] = isset( $new_instance['text'] ) ? $this->sanitize_text( $new_instance['text'] ) : '';
		}

		$instance['padding_y']           = isset( $new_instance['padding_y'] ) ? floatval( $new_instance['padding_y'] ) : 0;

		$instance['background_image']    = isset( $new_instance['background_image'] ) ? intval( $new_instance['background_image'] ) : 0;
		$instance['background_color']    = isset( $new_instance['background_color'] ) ? sanitize_text_field( $new_instance['background_color'] ) : '';

		$instance['thumbnail']           = isset( $new_instance['thumbnail'] ) ? intval( $new_instance['thumbnail'] ) : 0;

		$instance['border_top_color']    = isset( $new_instance['border_top_color'] ) ? sanitize_text_field( $new_instance['border_top_color'] ) : '';
		$instance['border_top_width']    = isset( $new_instance['border_top_width'] ) ? intval( $new_instance['border_top_width'] ) : 0;
		$instance['border_bottom_color'] = isset( $new_instance['border_bottom_color'] ) ? sanitize_text_field( $new_instance['border_bottom_color'] ) : '';
		$instance['border_bottom_width'] = isset( $new_instance['border_bottom_width'] ) ? intval( $new_instance['border_bottom_width'] ) : 0;

		$instance['title']               = isset( $new_instance['title'] ) ? $this->sanitize_text( $new_instance['title'] ) : '';
		$instance['title_color']         = isset( $new_instance['title_color'] ) ? sanitize_text_field( $new_instance['title_color'] ) : '';
		$instance['title_format']        = isset( $new_instance['title_format'] ) ? sanitize_text_field( $new_instance['title_format'] ) : '';

		$instance['subtitle']            = isset( $new_instance['subtitle'] ) ? $this->sanitize_text( $new_instance['subtitle'] ) : '';
		$instance['subtitle_format']     = isset( $new_instance['subtitle_format'] ) ? sanitize_text_field( $new_instance['subtitle_format'] ) : '';
		$instance['subtitle_color']      = isset( $new_instance['subtitle_color'] ) ? sanitize_text_field( $new_instance['subtitle_color'] ) : '';

		$instance['color']               = isset( $new_instance['color'] ) ? sanitize_text_field( $new_instance['color'] ) : '';
		$instance['text_wpautoped']      = ! empty( $new_instance['text_wpautoped'] );

		$instance['button_text']         = isset( $new_instance['button_text'] ) ? $this->sanitize_text( $new_instance['button_text'] ) : '';
		$instance['button_link']         = isset( $new_instance['button_link'] ) ? esc_url( $new_instance['button_link'] ) : '';
		$instance['button_target_blank'] = ! empty( $new_instance['button_target_blank'] );
		$instance['button_displayed']    = ! empty( $new_instance['button_displayed'] );
		$instance['button_format']       = isset( $new_instance['button_format'] ) ? sanitize_text_field( $new_instance['button_format'] ) : '';
		$instance['button_size']         = isset( $new_instance['button_size'] ) ? sanitize_text_field( $new_instance['button_size'] ) : '';

		$instance['layout']              = isset( $new_instance['layout'] ) ? sanitize_text_field( $new_instance['layout'] ) : '';
		$instance['container_layout']    = isset( $new_instance['container_layout'] ) ? sanitize_text_field( $new_instance['container_layout'] ) : '';

		return $instance;
	}

	/**
	 * Get the widget classes
	 *
	 * @param array $instance Settings for the current widget instance.
	 *
	 * @return array The widget classes
	 */
	protected function get_classes( $instance ) {
		$classes   = array( $instance['classes'] );
		$classes[] = "grimlock-section--{$instance['button_format']}";
		$title     = ! empty( $instance['title'] ) ? sanitize_title( $instance['title'] ) : '';

		if ( '' !== $title ) {
			$classes[] = "grimlock-section--{$title}";
		}

		return $classes;
	}

	/**
	 * Get the thumbnail url for the widget
	 *
	 * @param array $instance Settings for the current widget instance.
	 *
	 * @return string The thumbnail url
	 */
	protected function get_thumbnail_url( $instance ) {
		$thumbnail_url = '';

		if ( ! empty( $instance['thumbnail'] ) ) {
			$thumbnail_url = wp_get_attachment_image_url( $instance['thumbnail'], apply_filters( "{$this->id_base}_thumbnail_size", "thumbnail-{$instance['layout']}", $instance['layout'] ) );
		}

		return $thumbnail_url;
	}

	/**
	 * Get the thumbnail alt for the widget
	 *
	 * @param array $instance Settings for the current widget instance.
	 *
	 * @return string The thumbnail alt
	 */
	protected function get_thumbnail_alt( $instance ) {
		$thumbnail_alt = '';

		if ( ! empty( $instance['thumbnail'] ) ) {
			$thumbnail_alt = trim( strip_tags( get_post_meta( $instance['thumbnail'], '_wp_attachment_image_alt', true ) ) );
		}
		return $thumbnail_alt;
	}

	/**
	 * Get the thumbnail caption for the widget
	 *
	 * @param array $instance Settings for the current widget instance.
	 *
	 * @return string The thumbnail caption
	 */
	protected function get_thumbnail_caption( $instance ) {
		$thumbnail_caption = '';

		if ( ! empty( $instance['thumbnail'] ) ) {
			$thumbnail_caption = wp_get_attachment_caption( $instance['thumbnail'] );
		}

		return $thumbnail_caption;
	}

	/**
	 * Get the background image url for the widget
	 *
	 * @param array $instance Settings for the current widget instance.
	 *
	 * @return string The background image url
	 */
	protected function get_background_image_url( $instance ) {
		$background_image_url = '';

		if ( ! empty( $instance['background_image'] ) ) {
			$background_image_url = wp_get_attachment_image_url( $instance['background_image'], apply_filters( "{$this->id_base}_background_image_size", 'custom-header', $instance['layout'] ) );
		}

		return $background_image_url;
	}
}

return new Grimlock_Section_Widget_Fields();
