<?php

/**
 * Filter body_class
 */
function ot_body_classes( $classes ) {
    if( is_page_template( 'pages/home-template.php' ) ) {
        $classes[] = ' page-home';
    }
    if( is_archive( 'news' ) ) {
        $classes[] = ' page-news';
    }
    if( is_single() ) {
        $key = array_search( 'single-post', $classes );
        if( $key ) {
            unset($classes[$key]);
        }
        $classes[] = ' single-page';
    }
    return $classes;
}
add_filter( 'body_class', 'ot_body_classes' );

/**
 * Disable automatic <p> on CF7
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * WPML languages switcher
 */
function ot_language_switcher() {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

    if ( !empty( $languages ) ) : ?>
        <div class="lang-nav">
            <a href="#"><?php echo ICL_LANGUAGE_CODE; ?></a>
            <ul>
                <?php foreach( $languages as $l ) :
                    if( !$l['active'] ) : ?>
                        <li><a href="<?php echo $l['url']; ?>"><?php echo strtoupper( $l['language_code'] ); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
    endif;
}
