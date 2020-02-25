<?php
/**
 * Grimlock Login template functions.
 *
 * @package grimlock-login
 */

/**
 * Display register and login links for the navbar
 *
 * @param array $args The array of arguments from the component
 */
function grimlock_login_navbar_nav_menu_login_register_buttons( $args ) {
	if ( ! is_user_logged_in() ) : ?>

		<ul class="<?php echo esc_attr( join( ' ', $args['class'] ) ); ?>">
			<li class="menu-item menu-item--login">
				<button type="button" class="btn btn-outline-primary" data-target="#grimlock-login-form-modal" data-toggle="modal"><?php esc_html_e( 'Login', 'grimlock-login' ); ?></button>
			</li>
			<li class="menu-item menu-item--register">
				<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="btn btn-primary"><?php esc_html_e( 'Register', 'grimlock-login' ); ?></a>
			</li>
		</ul>

	<?php endif;
}

/**
 * Display the login form in a modal
 *
 * @param array $args The array of arguments from the component
 */
function grimlock_login_form_modal( $args ) {
	if ( ! is_user_logged_in() ) : ?>

		<div class="modal fade" id="grimlock-login-form-modal" tabindex="-1" role="dialog" aria-labelledby="grimlock-login-form-modal-title" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="grimlock-login-form-modal-title">
							<?php esc_html_e( 'Login', 'grimlock-login' ); ?>
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php wp_login_form(); ?>
					</div>
				</div>
			</div>
		</div>

	<?php endif;
}