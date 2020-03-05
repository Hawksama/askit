<?php
/**
 * Cera Child functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cera-child
 */

define( 'CERA_CHILD_VERSION', '1.0' );

/**
 * Initialize all the things.
 */
global $cera_child;
$cera_child = require get_stylesheet_directory() . '/inc/class-cera-child.php';

/**
 * Add your customizations below this line.
 */

add_action('admin_notices', 'propuneri_solutii_admin_notice');
function propuneri_solutii_admin_notice()
{
    global $pagenow;

    // Only show this message on the admin dashboard and if asked for
    if ('edit.php' === $pagenow && ! empty($_GET['post_type']))
    {
        echo '<div style="color: tomato;
            padding-right: 30px;
            background: white;
            padding-top: 10px;
            padding-bottom: 10px;
            font-weight: bold;
            padding-left: 10px;
            font-size: 19px;"><p style="font-size:19px; font-weight:bold;">News: Preluarea temelor de solutii din Solutii Propuse. Pasi:</p>
            <ul>
            <li>- Alege titlul pentru crearea unei solutii</li>
            <li>- Verifica la Autor ca Solutia sa nu fie asignata altei persoane</li>
            <li>- Edit:</li>
            <li>- Schimba la Autor in numele tau</li>
            <li>- Schimba statusul solutiei la "In Progress"</li>
            <li>- Save</li>
            <li>- Poti edita numele titlului </li>
            <li>- Verifica in interiorul solutiei detaliile ajutatoare, la *Situatie</li>
            <li>- Trecerea solutiei la statusul "Pending Review" si save</li>
            </ul>
            </div>';
    }
}

function appthemes_check_user_role( $role, $user_id = null ) {
    if ( is_numeric( $user_id ) )
        $user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
    
    if ( empty( $user ) )
        return false;
 
    return in_array( $role, (array) $user->roles );
}

add_action('admin_menu', 'no_posts_for_contributors');
function no_posts_for_contributors() {
  global $user_ID;

  if (appthemes_check_user_role("contributor")) {
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('tools.php');
    remove_menu_page('upload.php');
  }
}

add_action('admin_menu', 'add_propuneri_admin_menu_item');
function add_propuneri_admin_menu_item() {
                    // $page_title,            $menu_title, $capability, $menu_slug,           $callback_function
    add_submenu_page('edit.php?post_type=ht_kb', __('Solutii propuse'), __('Solutii propuse'),  'edit_others_posts', 'edit.php?post_type=ht_kb&post_status=solutii-propuse' );
}

add_action( 'admin_enqueue_scripts', 'remove_fields_from_profile_tab' );
function remove_fields_from_profile_tab($hook) {
    if ('profile.php' != $hook) {
        return;
    }

    if (!current_user_can('publish_posts')) {
	    $ss_url = get_stylesheet_directory_uri();

	    wp_enqueue_script( 'my_admin_script', "{$ss_url}/js/profile.js" );
    }

}

add_action('manage_users_custom_column', 'contributes_columns', 10, 3);
function contributes_columns( $value, $column_name, $user_id ) {

    if ( 'solutii' != $column_name )//Replace 'contributes' with the column name from the filter you previously created
        return $value;
    global $wp_query;
    $posts = query_posts('post_type=ht_kb&author='.$user_id.'&order=ASC&posts_per_page=30');//Replace post_type=contribute with the post_type=yourCustomPostName
    $posts_count = count($posts);
    $posts_count = "<a href='".site_url()."/wp-admin/edit.php?author={$user_id}&post_type=ht_kb'>{$posts_count}</a>";
    return $posts_count;
}

function custom_post_type() {
    add_post_type_support( 'ht_kb', 'post-formats' );
}
add_action( 'init', 'custom_post_type', 0 );

if ( (!current_user_can('manage_options') && is_user_logged_in()) || !is_user_logged_in() ) {
    add_filter('show_admin_bar', '__return_false');
}

add_action('admin_head', 'hide_editor');
function hide_editor() { 
  if(get_post_type() == 'ht_kb') { ?> 
    <style> #postdivrich { display:none; } </style> 
    <?php 
  }
}

/** Admin Enqueue **/
function admin_queue( $hook ) {
    global $post; 

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'ht_kb' === $post->post_type ) { 
            wp_enqueue_script( 'block-user-script-inserting', get_bloginfo( 'template_directory' ) . '-child/assets/js/admin/user-block-scripts.js', 'jquery', '', true );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'admin_queue' );



if ( ! function_exists( 'cera_grimlock_the_post_thumbnail' ) ) :
	/**
	 * Prints HTML for the post thumbnail :
	 *     - For the Video, Audio and Image formats, the post thumbnail is replaced by the media
	 *       found in the post content (either the video player, the image or the audio player).
	 *     - In any other case, the post thumbnail is displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param string $size The size for the thumbnail.
	 * @param array  $attr The array of attributes for the thumbnail tag.
	 */
	function cera_grimlock_the_post_thumbnail( $size = 'medium', $attr = array() ) {
		if ( has_post_format( array( 'video', 'audio', 'image', 'gallery' ) ) ) :
            if(has_post_format('video')):

                if(get_field('solutie_1')): 
                    $html = get_field('solutie_1');
                    $dom = new DOMDocument();
                    $dom->loadHTML($html);
                    $xpath = new DOMXPath($dom);
                    $div = $xpath->query('//div[@class="wp-video"]');
                    $div = $div->item(0);
                    $videoTag = $dom->saveXML($div);

                    if($videoTag): ?>
                        <div class="post-media post-media-video"><?= $videoTag ?></div>
                    <?php endif; 
                endif; 
            else: ?>
                <div class="post-media"><?php the_content(); ?></div>
            <?php endif;
		elseif ( has_post_thumbnail() ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-thumbnail" title="<?php the_title_attribute(); ?>" rel="bookmark">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</a>
			<?php
		endif;
	}
endif;

// Remove plugins updates because of the inline modifications made inside of them
function remove_plugin_updates( $value ) {
    unset( $value->response['buddypress/class-buddypress.php'] );
    unset( $value->response['ht-knowledge-base/ht-knowledge-base.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'remove_plugin_updates' );