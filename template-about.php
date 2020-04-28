<?php
/*
 * Template Name: About Us Template
 */
get_header(); ?>
    <?php if( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="container about-us-intro">
                <div class="about-us-intro__title-column title-column">
                    <?php the_title( '<p class="about-us-intro__big-title big-title">' , '</p>' ) ?>
                </div>
                <div class="about-us-intro__text-column">
                    <p class="about-us-intro__small-middle-title small-middle-title">
                        <?php echo get_the_content(); ?>
                    </p>
                </div>
            </div>
        <?php endwhile;
        if( have_rows( 'blocks' ) ) : ?>
            <?php while ( have_rows( 'blocks' ) ) : the_row(); ?>
                <?php if( get_row_layout() == 'image_section' ) : ?>
                    <?php if( $image = get_sub_field( 'image' ) ) : ?>
                        <div class="bg-img-wrap">
                            <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" class="bg-img">
                        </div>
                    <?php endif; ?>
                <?php elseif( get_row_layout() == 'rows_section' ) : ?>
                    <div class="container about-us-different">
                        <?php if( $block_title = get_sub_field( 'block_title' ) ) : ?>
                            <div class="about-us-different__title-column title-column">
                                <p class="about-us-different__middle-title middle-title">
                                    <?php echo $block_title; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <?php if( have_rows( 'rows' ) ) : ?>
                            <div class="about-us-different__text-column text-column">
                                <?php while ( have_rows( 'rows' ) ) : the_row(); ?>
                                    <div class="about-us-different__item">
                                        <?php if( $title = get_sub_field( 'title' ) ) : ?>
                                            <p class="about-us-different-list__small-middle-title small-middle-title">
                                                <?php echo $title; ?>
                                            </p>
                                        <?php endif;
                                        if( $description = get_sub_field( 'description' ) ) : ?>
                                            <p class="about-us-different-list__description description">
                                                <?php echo $description; ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif( get_row_layout() == 'about_section' ) : ?>
                    <div class="container about-us-origination">
                        <div class="about-us-origination__row-but-img row-but-img">
                            <div class="row-but-img__button-column  button-column">
                                <?php if( $block_title = get_sub_field( 'block_title' ) ) : ?>
                                    <p class="about-us-origination__middle-title middle-title">
                                        <?php echo $block_title; ?>
                                    </p>
                                <?php endif;
                                if( $description = get_sub_field( 'description' ) ) : ?>
                                    <p class="row-but-img__description description">
                                        <?php echo $description; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="row-but-img__img-column img-column">
                                <?php if( $vertical_img = get_sub_field( 'vertical_img' ) ) : ?>
                                    <div class="parallax-window about-us-origination__vertical-img" data-parallax="scroll" data-position="center center" data-speed="0.9" data-z-index="1" data-image-src="<?php echo $vertical_img['sizes']['large']; ?>"></div>
                                <?php endif;
                                if( $horizontal_img = get_sub_field( 'horizontal_img' ) ) : ?>
                                    <div class="parallax-window about-us-origination__horizontal-img" data-parallax="scroll" data-speed="0.9" data-z-index="1" data-image-src="<?php echo $horizontal_img['sizes']['large']; ?>"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif( get_row_layout() == 'staff_section' ) : ?>
                    <div class="container about-us-different">
                        <div class="about-us-different__title-column title-column">
                            <?php if( $block_title = get_sub_field( 'block_title' ) ) : ?>
                                <p class="about-us-different__middle-title middle-title">
                                    <?php echo $block_title; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <?php if( $description = get_sub_field( 'description' ) ) : ?>
                            <div class="about-us-different__text-column text-column">
                                <p class="about-us-different-list__description description">
                                    <?php echo $description; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if( $staff_ids = get_sub_field( 'staff' ) ) : ?>
                        <div class="container">
                            <p class="middle-title"><?php _e( 'Our Loan Officers' , 'stockton' ); ?></p>
                            <?php
                            $staff = new WP_Query( array(
                                'post_type'      => 'sil_staff',
                                'post_status'    => 'publush',
                                'posts_per_page' => -1,
                                'post__in'       => $staff_ids
                            ) );
                            if( $staff->have_posts() ) : ?>
                                <div class="location-officers">
                                    <?php while ( $staff->have_posts() ) : $staff->the_post(); ?>
                                        <div class="photo-card">
                                            <?php if( has_post_thumbnail() ) : ?>
                                                <img class="photo-card__photo" src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>" alt="">
                                            <?php endif; ?>
                                            <?php the_title( '<p class="photo-card__small-middle-title small-middle-title">' , '</p>'); ?>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif;
                            wp_reset_postdata(); ?>
                        </div>
                    <?php endif;
                elseif( get_row_layout() == 'careers_section' ) : ?>1
                    <div class="about-us-careers-wrapper">
                        <div class="container about-us-different">
                            <div class="about-us-different__title-column title-column">
                                <?php if( $block_title = get_sub_field( 'block_title' ) ) : ?>
                                    <p class="about-us-different__middle-title middle-title">
                                        <?php echo $block_title; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if( $description = get_sub_field( 'description' ) ) : ?>
                                <div class="about-us-different__text-column text-column">
                                    <p class="about-us-different-list__description description">
                                        <?php echo $description; ?>
                                    </p>
                                </div>
                            <?php endif;  ?>
                        </div>
                        <?php if( have_rows( 'careers' ) ) : ?>
                            <div class="container about-us-careers">
                                <?php while ( have_rows( 'careers' ) ) : the_row(); ?>
                                    <div class="about-us-careers__button-column button-column">
                                        <?php if( $title = get_sub_field( 'title' ) ) : ?>
                                            <p class="about-us-careers__title">
                                                <?php echo $title; ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="about-us-careers__content">
                                            <?php if( $description = get_sub_field( 'description' ) ) : ?>
                                                <p class="about-us-careers__description description">
                                                    <?php echo $description; ?>
                                                </p>
                                            <?php endif;
                                            if( $link = get_sub_field( 'link' ) ) : ?>
                                                <a href="<?php echo $link; ?>" class="link-button">
                                                    <div class="about-us-careers__custom-button custom-button">
                                                        <div class="custom-button__btn-bg"></div>
                                                        <div class="custom-button__btn-text"> <?php _e( 'Apply' , 'stockton' ); ?></div>
                                                    </div>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    <?php else : ?>
        <h1><?php get_template_part( 'blocks/not_found' ); ?></h1>
    <?php endif; ?>
<?php get_footer(); ?>
