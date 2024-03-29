<?php
/**
 * Grimlock_BuddyPress_Table_Customizer Class
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
 * The table class for the Customizer.
 */
class Grimlock_BuddyPress_Table_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_table_customizer_striped_background_color_elements', array( $this, 'add_striped_background_color_elements' ), 10, 1 );
		add_filter( 'grimlock_table_customizer_striped_background_color_outputs',  array( $this, 'add_striped_background_color_outputs'  ), 10, 1 );
	}

	/**
	 * Add CSS selectors to the array of CSS selectors for the striped table row background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The array of CSS selectors for the striped table row background color.
	 *
	 * @return array           The updated array of CSS selectors for the striped table row background color.
	 */
	public function add_striped_background_color_elements( $elements ) {
		return array_merge( $elements, array(
			'#buddypress:not(.youzer) .profile-content__body#item-body .screen-profile h2.screen-profile__title:after',
			'#buddypress:not(.youzer) table.notification-settings tbody tr td',
			'#buddypress:not(.youzer) table.profile-settings tbody tr td',
			'#buddypress:not(.youzer) table.notifications tbody tr td',
			'#buddypress:not(.youzer) table.messages-notices tbody tr td',
			'#buddypress:not(.youzer) table.profile-fields tbody tr td',
			'#buddypress:not(.youzer) table.notification-settings tbody tr:hover td',
			'#buddypress:not(.youzer) table.profile-settings tbody tr:hover td',
			'#buddypress:not(.youzer) table.notifications tbody tr:hover td',
			'#buddypress:not(.youzer) table.messages-notices tbody tr:hover td',
			'#buddypress:not(.youzer) table.profile-fields tbody tr:hover td',
			//'#buddypress:not(.youzer) div.item-list-tabs#subnav',
			'.group-invites #buddypress:not(.youzer) #group-create-body .left-menu div#invite-list > ul label:hover',
			'.group-invites #buddypress:not(.youzer) #send-invite-form > .invite .left-menu div#invite-list > ul label:hover',
			'#buddypress:not(.youzer) .rtmedia-list .rtmedia-list-item > a',
			'#buddypress:not(.youzer) .rtmedia-list .rtmedia-list-item .rtmedia-list-item-a',
			'#buddypress:not(.youzer) .rtmedia-uploader .drag-drop .rtm-select-files',
			'#buddypress:not(.youzer) .rtm-lightbox-container .rtmedia-single-meta .rtmedia-like-info',
			'#buddypress:not(.youzer) .rtm-comment-list .rtmedia-comment',
			'#buddypress:not(.youzer) #rtmedia-uploader-form .rtm-plupload-list li',
			'#buddypress:not(.youzer) #rtmedia_uploader_filelist li',
			'#buddypress:not(.youzer) .gallery-description',
			'#buddypress:not(.youzer) .rtm-tabs > li a',
			'#buddypress:not(.youzer) .rtmedia-edit-media-tabs.rtmedia-editor-main .rtm-tabs-content #manage-media-tab',
			'#buddypress:not(.youzer) .imgedit-panel-content',
			'#buddypress:not(.youzer) .imgedit-help',
			'#buddypress:not(.youzer) .rtm-load-more a',
			'#buddypress:not(.youzer) #activity-stream.grimlock-buddypress-activity-list .activity-item div.activity-comments > ul > li',
			'#buddypress:not(.youzer) .avatar-crop-management',
			'#buddypress:not(.youzer) .drag-drop #drag-drop-area',
			'#buddypress:not(.youzer) div.bp-avatar-status .bp-progress',
			'#buddypress:not(.youzer) div.bp-cover-image-status .bp-progress',
			'#buddypress:not(.youzer) .profile-content__body#item-body .screen-profile #profile-edit-form ul.button-nav > li a:hover',
			'#secondary-right .widget.buddypress.widget_bp_featured_members_list_widget .lSSlideOuter .lSPager > li > a',
			'#secondary-left .widget.buddypress.widget_bp_featured_members_list_widget .lSSlideOuter .lSPager > li > a',
			'#buddypress:not(.youzer) table.notification-settings tbody tr td',
			'#buddypress:not(.youzer) table.profile-settings tbody tr td',
			'#buddypress:not(.youzer) table.notifications tbody tr td',
			'#buddypress:not(.youzer) table#message-threads tbody tr td',
			'#buddypress:not(.youzer) table.profile-fields tbody tr td',
			'#buddypress:not(.youzer) table.notification-settings tbody tr:hover td',
			'#buddypress:not(.youzer) table.profile-settings tbody tr:hover td',
			'#buddypress:not(.youzer) table.notifications tbody tr:hover td',
			'#buddypress:not(.youzer) table#message-threads tbody tr:hover td',
			'#buddypress:not(.youzer) table.profile-fields tbody tr:hover td',
			'#bbpress-forums ul.bbp-search-results div.bbp-forum-header',
			'#buddypress:not(.youzer) div#message-thread .message-box.alt',
			'.bb-global-search-ac.ui-menu .ui-menu-item:hover',
			'#members-index-swap #pag-bottom .prev',
			'#members-index-swap #pag-bottom .next',
			'#ai_ar_main .ai_bp_reactions_counter > a > span',
			'#ai_ar_main .ai_bp_reactions_default_cont > .ai_emo_button',
			'.activity-meta a.bpmts-report-button',
			'.vex.vex-theme-flat-attack .vex-content ul li',
			'.bp-messages-wrap .reply',
			'.bp-messages-wrap .list .messages-stack:hover',
			'.bp-messages-wrap .threads-list .thread:hover > *',
			'.bp-messages-wrap .list .messages-stack .content .messages-list > li',
			'.bupr-row .multi-review',
			'#buddypress:not(.youzer) button.visibility-toggle-link',
			'#buddypress:not(.youzer) div.section .rtm-privacy-levels',
			'#buddypress:not(.youzer) .standard-form .checkbox',
			'#buddypress:not(.youzer) .standard-form .radio',
			'.widget_bp_birthday_widget ul.birthday-members-list li',
			'.widget.buddypress #message',
			'.widget ul.item-list > li:hover',
			// TODO : Migrate to BP DOCS class
			'#buddypress .standard-form label[for="bp-docs-group-enable"]',
			'[class*="widget_recent_bp_docs"] ul li',
			'#doc-permissions-details',
			'.doc-content #doc-attachments-ul',
			'.entry-content p.toggle-switch',
			'.toggle-switch',
			'.folder-toggle-link',
			// TODO : Migrate to BP Global search class
			'.bb-global-search-ac.ui-autocomplete .bboss_ajax_search_item > a:hover',
			'#buddypress:not(.youzer) .field-visibility-settings-toggle button',
			'#buddypress:not(.youzer) button.field-visibility-settings-close',
			'#buddypress:not(.youzer) .rtm-lightbox-container .rtmedia-single-meta #comment_content',
		) );
	}

	/**
	 * Add selectors and properties to the CSS rule-set for the striped table row background color.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $outputs The array of CSS selectors and properties for the striped table row background color.
	 *
	 * @return array          The updated array of CSS selectors for the striped table row background color.
	 */
	public function add_striped_background_color_outputs( $outputs ) {
		return array_merge( $outputs, array(
			array(
				'element'  => implode( ',', array(
					'.ai_reaction_loader_inner',
					'#buddypress .standard-form #group-doc-options',
				) ),
				'property' => 'border-color',
			),
			array(
				'element'  => implode( ',', array(
					'#buddypress:not(.youzer) div.dir-search > form input[type="text"]:hover',
					'#buddypress:not(.youzer) div.dir-search > form input[type="search"]:hover',
					'#buddypress:not(.youzer) div.message-search > form input[type="text"]:hover',
					'#buddypress:not(.youzer) div.message-search > form input[type="search"]:hover',
					'#buddypress:not(.youzer) .rtm-gallery-title',
					'#buddypress:not(.youzer) .rtmedia-media-edit > h2',
					'#buddypress:not(.youzer) .rtmedia-single-edit-title-container > .rtmedia-title',
					'#buddypress:not(.youzer) #media_search_form #media_search_input:hover',
					'#buddypress:not(.youzer) .rtm-lightbox-container .rtmedia-single-meta .rtmedia-like-info:after',
					'#bbpress-forums li.bbp-body ul.forum',
					'#bbpress-forums li.bbp-body ul.topic',
				) ),
				'property' => 'border-bottom-color',
			),
			array(
				'element'  => implode( ',', array(
					'#buddypress .standard-form div.submit',
				) ),
				'property' => 'border-top-color',
			),
			array(
				'element'     => implode( ',', array(
					'.main-navigation .navbar-nav.navbar-nav--buddypress.logged-out .menu-item--profile .sub-menu',
				) ),
				'property'    => 'background-color',
				'media_query' => '@media (max-width: 992px)',
			),
		) );
	}
}

return new Grimlock_BuddyPress_Table_Customizer();
