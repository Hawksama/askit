<?php
global $post, $wpdb, $bp, $socialArticles;

$directWorkflow = isDirectWorkflow();

$statusLabels = array("publish"=>__('Published mode', 'social-articles'),
    "draft"=>__('Draft mode', 'social-articles'),
    "pending"=>__('Under review', 'social-articles'),
    "new-post"=>__('New', 'social-articles'));


$article_id = empty($_GET['article']) ? 0 : $_GET['article']; //Used by all fields
$article = new SA_Form($article_id);

$error_message = '';
$response = array();
$response['status'] = false;

if('POST' == $_SERVER['REQUEST_METHOD']){
    // $retrieved_nonce = $_REQUEST['_wpnonce'];
    // if (!wp_verify_nonce($retrieved_nonce, 'sa_create' ) ) die( 'Failed security check' );

    $response = $article->save($_POST);
    if(!$response['status']){
        $error_message = '<div class="sa-error-container">';
        foreach ($response['messages'] as $message){
            $error_message .= '<p>'.$message.'</p>';
        }
        $error_message .= '</div>';
    };
}
?>

<?php if($response['status'] == true): ?>
    <div class="post-save-options messages-container">
        <label id="save-message"><?php echo $response['saved_data']['message']; ?></label>
        <input type="submit" onclick="window.open('<?php echo $response['saved_data']['editarticle'];?>', '_self');" id="edit-article" class="button" value="<?php _e("Edit article", "social-articles"); ?>" />
        <input type="submit" onclick="window.open('<?php echo $response['saved_data']['viewarticle'];?>', '_self');"id="view-article" class="button" value="<?php _e("View article", "social-articles"); ?>" />
        <input type="submit" onclick="window.open('<?php echo $response['saved_data']['newarticle'];?>', '_self');"id="new-article" class="button" value="<?php _e("New article", "social-articles"); ?>" />
    </div>
<?php else: ?>
    <div class="saving-message" style="display: none; text-align: center">
        <p><?php _e('Saving your article. Please wait.', 'social-articles');?></p>
        <p><img src="<?php echo SA_BASE_URL;?>/assets/images/loading.svg" width="60"></p>
    </div>
    <div id="post-maker-container">
        <?php 
        echo $error_message;
        
        $article->show_article_status_custom($statusLabels);

        acf_form_head();
        
        $formoptions = array(
            'post_id'         => $article_id,
            'post_title'      => true,
            'post_content'    => false,
            'new_post'        => array(
                'post_type'       => 'ht_kb', // change this to the post type you need
                'post_status'     => 'pending' // do you want the post to be published immediately? otherwise change this to 'draft', or 'publish' or 'pending'
            ),
            'submit_value'    => __('Send for review', 'social-articles'),
            'html_after_fields' => '<input type="hidden" id="frontendPostStatus" name="acf[current_step]" value="1"/>'
        );?>

        <input type="submit" id="draft_btn" class="acf-button2 button button-primary button-large" name="draft_btn" value="<?= __('Save as Draft', 'social-articles'); ?>">

        <?php

        acf_form($formoptions);

        if ($article_id != 0):
            $argsComments = array(
                'post_id'   => $article_id,
                'type'      => 'editorial-comment',
                'status'    => 'editorial-comment',
                'order'     => 'ASC',
                'orderby' => 'comment_date',
            );
            $comments = get_comments($argsComments); 
            if(sizeof($comments)):?>
                <ul class="comments-listing">
                    <?php
                    wp_list_comments(
                        array(
                            'type' => 'editorial-comment',
                            'end-callback' => '__return_false'
                        ),
                        $comments
                    ); ?>
                </ul> <?php
            endif;
        endif;
        ?>
    </div>
<?php endif; ?>

