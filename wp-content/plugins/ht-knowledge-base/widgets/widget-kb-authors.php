<?php

class HT_KB_Authors_Widget extends WP_Widget {

/*--------------------------------------------------*/
/* Constructor
/*--------------------------------------------------*/

/**
* Specifies the classname and description, instantiates the widget,
* loads localization files, and includes necessary stylesheets and JavaScript.
*/
public function __construct() {

      // ENSURE: update classname and description
      parent::__construct(
      'ht-kb-authors-widget',
      __( 'Knowledge Base Authors', 'ht-knowledge-base' ),
      array(
      'classname' =>  'HT_KB_Authors_Widget',
      'description' =>  __( 'A widget for displaying top Knowledge base authors', 'ht-knowledge-base' )
      )
      );

      } // end constructor

      /*--------------------------------------------------*/
      /* Widget API Functions
      /*--------------------------------------------------*/

      /**
      * Outputs the content of the widget.
      *
      * @param array args The array of form elements
      * @param array instance The current instance of the widget
      */
      public function widget( $args, $instance ) {

      extract( $args, EXTR_SKIP );

      $title = $instance['title'];

      $view_count_meta_key = '';



      $valid_sort_orders = array( 'authored', 'helpful');
      if ( in_array($instance['sort_by'], $valid_sort_orders) ) {
        $sort_by = $instance['sort_by'];
        $sort_order = (bool) $instance['asc_sort_order'] ? 'ASC' : 'DESC';
      } else {
        // by default, display latest first
        $sort_by = 'date';
        $sort_order = 'DESC';
      }



      $authors  = array(); 

      //authored
      if($sort_by== 'authored'){
        //populate the authors array with their count of their authored posts
        
        $ht_kb_posts = get_posts( array( 
            'post_type' => 'ht_kb', 
            'order' => $sort_order,
            'nopaging'  => true, // display all posts
        ) ) ;
        foreach ($ht_kb_posts as $key => $post) {
          //increment the count
          $authors[$post->post_author] = ( array_key_exists( $post->post_author, $authors ) ) ? $authors[$post->post_author] + 1 : 1;
        }

        if($sort_order=='ASC')
          asort($authors);
        else
          arsort($authors);
      }

      //helpful
      if($sort_by== 'helpful'){

        $sort_by = 'meta_value_num';
        $view_count_meta_key = HT_USEFULNESS_KEY;

        $args = array(
        'orderby' => $sort_by,
        'order' => $sort_order,
        'meta_key' => $view_count_meta_key,
        ); 
        //populate the authors array with their count of their helpfulness
        $user_query = new WP_User_Query( $args );

        $results = $user_query->results;

        //poulate
        if ( ! empty( $results ) ) {
          foreach ( $results as $user ) {
            $usefulness = get_user_meta($user->ID, HT_USEFULNESS_KEY, true);
            $authors[$user->ID] = $usefulness;
          }
        }

        //order 
        if($sort_order=='ASC')
          asort($authors);
        else
          arsort($authors);


      }


      echo $before_widget;

      if ( $title )
        echo $before_title . $title . $after_title;



      if(! empty( $authors ) ) :

        //get the number of display authors
        $num = intval( $instance['num'] );
        //set counter
        $counter = 0;
      ?>

      <ul class="clearfix">


      <?php foreach ( $authors as $user_id => $meta ): ?>

        <?php if($counter>=$num) break; ?>

        <?php $user = get_userdata($user_id); ?>

        <li class="clearfix <?php if ($instance["avatar"]) {  ?>has-avatar<?php }  ?>"> 

        <?php if ( true  ):  ?>
          <div class="ht-kb-author-avatar">
            <a href="<?php echo get_author_posts_url( $user->ID ); ?>" rel="nofollow">
            <?php echo get_avatar( $user->ID , 32 ); ?>
            </a>
          </div>
        <?php endif; //if true?>

        <a class="widget-user-title" href="<?php echo get_author_posts_url($user->ID); ?>" rel="bookmark" title=""><?php echo get_the_author_meta( 'display_name', $user->ID ); ?></a>

        <?php if ( $sort_by == 'authored'  ):  ?>
          <div class="ht-kb-authored-count">
<!--           Askit
 -->            <?php echo "Solutii Create"; //_e('Articles Authored', 'ht-knowledge-base'); ?>
<!--  end Askit
 -->            <span><?php echo $meta; ?></span>
          </div>
        <?php endif; //if true?>

        <?php if ( $sort_by == 'meta_value_num'  ): ?>
          <div class="ht-kb-helpfulness-rating">
            <?php _e('Rating', 'ht-knowledge-base'); ?>
            <span><?php echo $meta; ?></span>
          </div>
        <?php endif; //if true?>

        

        </li>
        <?php $counter++; ?>
       <?php endforeach; ?>
      </ul>

      <?php endif;

      echo $after_widget;

      } // end widget

      /**
      * Processes the widget's options to be saved.
      *
      * @param array new_instance The previous instance of values before the update.
      * @param array old_instance The new instance of values to be generated via the update.
      */
      public function update( $new_instance, $old_instance ) {

      $instance = $old_instance;

      //update widget's old values with the new, incoming values
      $instance['title'] = strip_tags( $new_instance['title'] );
      $instance['num'] = $new_instance['num'];
      $instance['sort_by'] = $new_instance['sort_by'];
      $instance['asc_sort_order'] = $new_instance['asc_sort_order'] ? 1 : 0;
      $instance['avatar'] = $new_instance['avatar'] ? 1 : 0;

      return $instance;

      } // end widget

      /**
      * Generates the administration form for the widget.
      *
      * @param array instance The array of keys and values for the widget.
      */
      public function form( $instance ) {

          $default_widget_title = __('Knowledge Base Authors', 'ht-knowledge-base');

          $defaults = array(
            'title' => $default_widget_title,
            'num' => '5',
            'sort_by' => '',
            'asc_sort_order' => '',
            'avatar' => true,
          );
          $instance = wp_parse_args((array) $instance, $defaults);

          // Store the values of the widget in their own variable

          $title = strip_tags($instance['title']);
          $num = $instance['num'];
          $sort_by = $instance['sort_by'];
          $asc_sort_order = $instance['asc_sort_order'];
          $avatar = $instance['avatar'];
          ?>
          <label for="<?php echo $this->get_field_id("title"); ?>">
            <?php _e( 'Title', 'ht-knowledge-base' ); ?>
            :
            <input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
          </label>
          </p>
          <p>
            <label for="<?php echo $this->get_field_id("num"); ?>">
              <?php _e( 'Number of authors to show', 'ht-knowledge-base' ); ?>
              :
              <input style="text-align: center;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo absint($instance["num"]); ?>" size='3' />
            </label>
          </p>
          <p>
            <label for="<?php echo $this->get_field_id("sort_by"); ?>">
              <?php _e( 'Sort by', 'ht-knowledge-base' ); ?>
              :
              <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
                <option value="authored"<?php selected( $instance["sort_by"], "authored" ); ?>><?php _e( 'Articles Authored', 'ht-knowledge-base' ); ?></option>
                <option value="helpful"<?php selected( $instance["sort_by"], "helpful" ); ?>><?php _e( 'Most Helpful', 'ht-knowledge-base' ); ?></option>
              </select>
            </label>
          </p>
          <p>
            <label for="<?php echo $this->get_field_id("asc_sort_order"); ?>">
              <input type="checkbox" class="checkbox"
          id="<?php echo $this->get_field_id("asc_sort_order"); ?>"
          name="<?php echo $this->get_field_name("asc_sort_order"); ?>"
          <?php checked( (bool) $instance["asc_sort_order"], true ); ?> />
              <?php _e( 'Reverse sort order (ascending)', 'ht-knowledge-base' ); ?>
            </label>
          </p>

          <p>
            <label for="<?php echo $this->get_field_id('avatar'); ?>">
              <input type="checkbox" <?php echo $avatar; ?> class="checkbox" id="<?php echo $this->get_field_id('avatar'); ?>" name="<?php echo $this->get_field_name('avatar'); ?>"<?php checked( (bool) $instance["avatar"], true ); ?> />
              <?php _e( 'Show user avatar', 'ht-knowledge-base' ); ?>
            </label>
          </p>
      <?php } // end form





} // end class

//Remember to change 'Widget_Name' to match the class name definition
add_action( 'widgets_init', create_function( '', 'register_widget("HT_KB_Authors_Widget");' ) );
