<?php
/**
 * Cera_Grimlock_Learndash_Archive_Customizer Class
 *
 * @author   Themosaurus
 * @since    1.0.0
 * @package grimlock
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The post archive page class for the Customizer.
 */
class Cera_Grimlock_Learndash_Archive_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_archive_customizer_elements',                       array( $this, 'add_elements'                       ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_background_color_elements', array( $this, 'add_post_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_color_outputs',      array( $this, 'add_post_border_color_outputs'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_box_shadow_color_outputs',  array( $this, 'add_post_box_shadow_color_outputs'  ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_title_color_elements',      array( $this, 'add_post_title_color_elements'      ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_link_hover_color_elements', array( $this, 'add_post_link_hover_color_elements' ), 10, 1 );
		add_filter( 'grimlock_archive_customizer_post_border_radius_elements',    array( $this, 'add_post_border_radius_elements'    ), 10, 1 );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post.
	 *
	 * @return array           The updated array of CSS selectors for the archive post.
	 */
	public function add_elements( $elements ) {
		return array_merge( $elements, array(
			'#learndash_lessons',
			'#learndash_quizzes',
			'#learndash_profile',
			'#learndash_lesson_topics_list > div',
			'#ld_course_info',
			'#ld_course_list .thumbnail',
			'.single-sfwd-certificates .sfwd-certificates',
			'.wpProQuiz_quiz',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post background color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post background color.
	 */
	public function add_post_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'.wpProQuiz_content .wpProQuiz_questionList',
			'.wpProQuiz_content .wpProQuiz_questionList',
			'.wpProQuiz_content .wpProQuiz_sortable',
			'.wpProQuiz_sortStringItem',
			'.wpProQuiz_content .wpProQuiz_catOverview span',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border color.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border color.
	 */
	public function add_post_border_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'#lessons_list > div h4',
					'#course_list > div h4',
					'#quiz_list > div h4',
					'#learndash_lesson_topics_list ul > li > span.topic_item',
					'#learndash_lessons > div > div, #learndash_quizzes > div > div',
					'#lessons_list > div > div',
					'#course_list > div > div',
					'#quiz_list > div > div',
					'#single-sfwd-lessons #learndash_lesson_topics_list ul > li > span.sn',
					'#singular-sfwd-lessons #learndash_lesson_topics_list ul > li > span.sn',
					'.wpProQuiz_content .wpProQuiz_questionList',
					'#learndash_lesson_topics_list div > strong',
					'#learndash_lessons > div > div',
					'#learndash_quizzes > div > div',
				) ),
				'property' => 'border-color',
			),
			array(
				'element'  => implode( ',', array(
					'.modal .modal-header',
				) ),
				'property' => 'border-bottom-color',
			),
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the archive post border width.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the archive post border width.
	 *
	 * @return array          The updated array of CSS selectors for the archive post border width.
	 */
	public function add_post_box_shadow_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'       => implode( ',', array(
					'.ld_course_grid > .thumbnail:hover',
				) ),
				'property'      => 'box-shadow',
				'value_pattern' => '0 20px 20px $',
				'media_query'   => '@media (min-width: 768px)',
			),
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post title color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post title color.
	 *
	 * @return array           The updated array of CSS selectors for the archive post title color.
	 */
	public function add_post_title_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#lessons_list > div h4',
			'#course_list > div h4',
			'#quiz_list > div h4',
			'#learndash_lesson_topics_list ul > li > span.topic_item',
			'#ld_course_list .thumbnail',
			'.ld_course_grid .entry-title',
			'.wpProQuiz_content .wpProQuiz_header',
			'.wpProQuiz_content .wpProQuiz_catOverview span',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post link color on hover.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post link color on hover.
	 *
	 * @return array           The updated array of CSS selectors for the archive post link color on hover.
	 */
	public function add_post_link_hover_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#learndash_lessons h4 > a:hover',
			'#learndash_quizzes h4 > a:hover',
			'#learndash_topics h4 > a:hover',
			'#learndash_lesson_topics_list ul > li > span.topic_item:hover',
		) );
	}

	/**
	 * Add CSS selectors from the array of CSS selectors for the archive post border radius.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the archive post border radius.
	 *
	 * @return array           The updated array of CSS selectors for the archive post border radius.
	 */
	public function add_post_border_radius_elements( $elements ) {
		return array_merge( $elements, array(
			'#course_progress_details',
		) );
	}
}

return new Cera_Grimlock_Learndash_Archive_Customizer();
