<?php

/**
* Include and setup custom metaboxes and fields.
*/

if (!class_exists('HT_Knowledge_Base_Meta_Boxes')) {

    class HT_Knowledge_Base_Meta_Boxes {

    	//Constructor
    	public function __construct() {
    		add_filter( 'cmb_meta_boxes', array( $this, 'ht_knowledge_base_register_meta_boxes') );
    		add_action( 'init', array( $this, 'cmb_initialize_cmb_meta_boxes'), 9999 );
    		add_action( 'add_meta_boxes', array( $this, 'display_rating_metaboxes' ) );
    	 }

    	 /**
		 * Register meta boxes
		 * @uses the meta-boxes module
		 * @param (Array) $meta_boxes The exisiting metaboxes
		 * @param (Array) Filtered metaboxes
		 */
		function ht_knowledge_base_register_meta_boxes( array $meta_boxes ) {

			$prefix = 'ht_knowledge_base_';

			// 1st meta box
			$meta_boxes[] = array(
				// Meta box id, UNIQUE per meta box. Optional since 4.1.5
				'id' => 'kb_meta',
				// Meta box title - Will appear at the drag and drop handle bar. Required.
				'title' => __( 'Article Options', 'ht-knowledge-base' ),
				// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
				'pages' => array( 'ht_kb' ),
				// Where the meta box appear: normal (default), advanced, side. Optional.
				'context' => 'normal',
				// Order of meta box: high (default), low. Optional.
				'priority' => 'high',
				// Auto save: true, false (default). Optional.
				'autosave' => true,
				// List of meta fields
				'fields' => array(
					array(
						'name' => __( 'Attachments', 'ht-knowledge-base' ),
						'id'   => $prefix .'file_advanced',
						'type' => 'file_list',
						'max_file_uploads' => 4,
						'mime_type' => '', // Leave blank for all file types
					),
					// CHECKBOX
					array(
						'name' => __( 'Allow Voting', 'ht-knowledge-base' ),
						'id'   => $prefix .'voting_checkbox',
						'type' => 'checkbox',
						'default' => true
						
					),					
				)
			);
			return $meta_boxes;
		}

		/**
		 * Initialize the metabox class.
		 */
		function cmb_initialize_cmb_meta_boxes() {

			if ( ! class_exists( 'cmb_Meta_Box' ) )
				require_once dirname( dirname( __FILE__ ) ) . '/custom-metaboxes/init.php';
		}

		function display_rating_metaboxes(){
			
				add_meta_box(
					'rating_settings',
					__( 'Article Rating', 'ht-knowledge-base' ),
					array( $this, 'display_rating_callback' ),
					'ht_kb',
					'advanced',
					'high'
				);

		}

		/**
		 * Prints the box content.
		 * @param (Object) $post The WP Post object for the current post/page.
		 */
		function display_rating_callback( $post ) {

			
			/*
			 * Use get_post_meta() to retrieve an existing value
			 * from the database and use the value for the form.
			 */
			$value = get_post_meta( $post->ID, '_ht_kb_usefulness', true );

			echo '<label for="usefulness">';
			_e( 'Usefulness', 'ht-knowledge-base' );
			echo '</label> ';
			echo '<input type="text" id="usefulness" name="usefulness" value="' . esc_attr( $value ) . '" size="10" disabled />';
		}


    } //end class

}//end class exists


//run the module
if(class_exists('HT_Knowledge_Base_Meta_Boxes')){
	$ht_knowledge_base_meta_boxes_init = new HT_Knowledge_Base_Meta_Boxes();
}
