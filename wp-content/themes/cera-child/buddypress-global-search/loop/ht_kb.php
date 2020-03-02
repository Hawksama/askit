<li class="bboss_search_item bboss_search_ht_kb">
    <h3 class="entry-title">
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'buddypress-global-search' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h3>

    <div class="entry-content entry-summary">
        <?php

        $postSummary = get_field('situatie');
        $deleteInlineJs = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $postSummary);
        $deleteTags = strip_tags($deleteInlineJs);
        $deleteSpaces = str_replace(array("\r", "\n"), '', $deleteTags);

        $summary = implode(' ', array_slice(explode(' ', $deleteSpaces), 0, 20));
        echo $summary  . " [...]"; ?>

    </div><!-- .entry-content -->
</li>
