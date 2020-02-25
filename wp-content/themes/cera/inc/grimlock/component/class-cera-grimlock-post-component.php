<?php
/**
 * Class Cera_Grimlock_Post_Component
 *
 * @author  themosaurus
 * @since   1.0.0
 * @package grimlock/inc/components
 */

// @codingStandardsIgnoreFile
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Cera_Grimlock_Post_Component' ) ) :

	/**
	 * Cera Grimlock Post Component class.
	 */
	class Cera_Grimlock_Post_Component extends Grimlock_Component {
		/**
		 * Create a new Grimlock_Component instance.
		 *
		 * @param array $props Array of variables to be used within template.
		 */
		public function __construct( $props = array() ) {
			parent::__construct( wp_parse_args( $props, array(
				'post_thumbnail_displayed' => true,
				'post_thumbnail_size'      => 'medium',
				'post_thumbnail_attr'      => array( 'class' => 'card-img' ),
				'post_date_displayed'      => true,
				'post_author_displayed'    => true,
				'post_content_displayed'   => false,
				'post_excerpt_displayed'   => true,
				'post_more_link_displayed' => true,
				'category_displayed'       => true,
				'post_tag_displayed'       => true,
				'post_format_displayed'    => true,
				'comments_link_displayed'  => true,
			) ) );
		}

		/**
		 * Render the current component with props data on page.
		 *
		 * @since 1.0.0
		 */
		public function render() {
			?>
			<div class="card">

				<?php
				if ( true == $this->props['post_thumbnail_displayed'] ) :
					do_action( 'grimlock_post_thumbnail', $this->props['post_thumbnail_size'], $this->props['post_thumbnail_attr'] );
				endif; ?>

				<div class="card-body">

					<?php
					if ( true == $this->props['post_format_displayed'] && 'post' === get_post_type() &&  ( has_post_format() || is_sticky() ) ) : ?>
						<div class="card-body-labels entry-labels">
							<?php
							cera_the_sticky_mark();
							cera_the_post_format(); ?>
						</div>
					<?php
					endif; ?>

					<header class="card-body-header entry-header">
						<?php
						if ( 'post' === get_post_type() && true == $this->props['category_displayed'] ) : ?>
							<div class="card-body-meta entry-meta">
								<?php do_action( 'grimlock_category_list' ); ?>
							</div><!-- .entry-meta -->
						<?php endif; ?>
						<?php the_title( '<h2 class="entry-title h4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
					</header><!-- .entry-header -->

					<?php
					$more_link_text = '';
					if ( true == $this->props['post_more_link_displayed'] ) :
						$more_link_text = apply_filters( 'grimlock_post_more_link_text', $more_link_text );
					endif;

					if ( true == $this->props['post_content_displayed'] || true == $this->props['post_tag_displayed'] && has_tag() ) : ?>

					<div class="card-body-content entry-content">

						<?php if ( true == $this->props['post_content_displayed'] ): ?>
							<?php
							the_content( $more_link_text );
							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cera' ),
								'after'  => '</div>',
							) ); ?>
						<?php endif; ?>

						<?php if ( true == $this->props['post_excerpt_displayed'] ) :
								$more_link = '';
								if ( '' !== $more_link_text ) :
									$more_link = '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" class="more-link btn btn-link btn-sm">' . $more_link_text . '</a>';
								endif;

								do_action( 'grimlock_post_excerpt', $more_link );
						endif; ?>

						<?php if ( true == $this->props['post_tag_displayed'] && has_tag() ) : ?>
							<?php do_action( 'grimlock_post_tag_list' ); ?>
						<?php endif; ?>

					</div><!-- .entry-content -->

					<?php
					endif; ?>

				</div><!-- .card-body -->

				<?php if ( ( 'post' === get_post_type() ) && ( ( true == $this->props['comments_link_displayed'] && comments_open() ) || ( true == $this->props['post_author_displayed'] ) ) ) : ?>
					<footer class="card-footer entry-footer">
						<?php
						if ( true == $this->props['post_author_displayed'] ) :
							do_action( 'grimlock_post_author' );
						endif;

						if ( true == $this->props['post_date_displayed'] ) :
							do_action( 'grimlock_post_date' );
						endif;

						if ( true == $this->props['comments_link_displayed'] ) : ?>
							<?php do_action( 'grimlock_comments_link' ); ?>
						<?php
						endif; ?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>

			</div><!-- .card -->
			<?php
		}
	}
endif;
