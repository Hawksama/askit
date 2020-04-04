<?php
/**
 * Class Cera_Grimlock_Hamburger_Navbar_Component
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock/inc/components
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_Grimlock_Hamburger_Navbar_Component' ) ) :

	/**
	 * Cera Grimlock Haburger Navbar Component class.
	 */
	class Cera_Grimlock_Hamburger_Navbar_Component extends Grimlock_Hamburger_Navbar_Component {


		/**
		 * Output the navbar collapsible search form.
		 *
		 * @since 1.0.0
		 */
		function render_search_form() {
			if ( true == $this->props['search_form_displayed'] ) : ?>
				<ul class="nav navbar-nav navbar-nav--search d-none d-lg-flex pr-5">
					<li class="menu-item">
						<div class="navbar-search d-flex align-items-center">
							<span class="search-icon "><i class="cera-icon cera-search"></i></span>
							<?php get_search_form(); ?>
						</div><!-- .navbar-search -->
					</li><!-- .menu-item -->
				</ul><!-- .navbar-nav -->
			<?php
			endif;
		}

		/**
		 * Output the navbar collapsible search form.
		 *
		 * @since 1.0.0
		 */
		function render_secondary_nav_menu() {
			do_action( 'cera_grimlock_navbar_secondary_nav_menu', array(
				'container'  => false,
				'menu_class' => 'hamburger-navbar-nav nav navbar-nav navbar-nav--hamburger-secondary-menu d-none d-lg-flex',
			) );
		}

		/**
		 * Display the current component with props data on page.
		 *
		 * @since 1.0.0
		 */
		public function render() {
			?>
			<<?php $this->render_el(); ?> <?php $this->render_id(); ?> <?php $this->render_class( 'navbar-full' ); ?> <?php $this->render_style(); ?> <?php $this->render_role(); ?>>
			<div class="navbar__container d-flex">
				<div class="navbar__header d-lg-none">

					<div class="menu-item menu-item-call-us mobile">
						<a class="btn btn-primary" href="tel:+4<?= get_option('phone_number'); ?>">
							<div>
								<i class="fa fa-phone"></i>
							</div>
							<div class="phone_number_wrapper">
								<div class="phone_number_label">
									<?= get_option('phone_number_label'); ?>
								</div>
								<div class="phone_number">
									<?= get_option('phone_number'); ?>
								</div>
							</div>
						</a>
					</div>

					<?php
						$this->render_toggler();
						$this->render_brand(); ?>
				</div><!-- .navbar__header -->
				<?php $this->render_search_form(); ?>
				<?php $this->render_secondary_nav_menu(); ?>
				<div class="hamburger-navbar-nav-menu-container d-none d-lg-flex col-auto pr-0">
					<?php $this->render_nav_menu(); ?>
				</div><!-- .collapse -->
			</div><!-- .navbar__container -->
			</<?php $this->render_el(); ?>><!-- .navbar -->
			<?php
		}
	}
endif;
