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