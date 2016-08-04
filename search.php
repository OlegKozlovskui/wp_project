<?php get_header(); ?>
<div class="content">
    <section class="section bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-sm-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="caption-style-2">
                                <h2 class="h2">
                                    <span>Binaryrobot365</span>
                                    Search page
                                </h2>

                                <div class="simple-text sm white">
                                    <p><?php printf( __( 'Search Results for: %s', 'robot' ), get_search_query() ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="simple-text white">
                                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                    <div class="post">
                                        <div class="post-info">
                                            <span class="post-author">By: <?php the_author(); ?></span>
                                            <span class="post-date"><?php the_time('F j, Y'); ?></span>
                                        </div>
                                        <?php if (has_post_thumbnail()) { ?>
                                            <a class="post-img" href="<?php the_permalink(); ?>">
                                                  <?php the_post_thumbnail();  ?>
                                            </a>
                                            <h2 class="post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>
                                            <div class="excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php endwhile;
                                else: ?>
                                    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'binaryrobot' ); ?></p>

                                <?php endif; ?>
                            </div>
                            <?php
                            the_posts_pagination( array(
                                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'binaryrobot' ) . ' </span>',
                            ) );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php get_footer(); ?>

