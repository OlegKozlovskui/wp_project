<?php get_header(); ?>	<!--CONTENT-->	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>				<?php the_content(); ?>	<?php endwhile; else: ?>	<?php endif; ?>	<!--COMMENTS-->	<?php while ( have_posts() ) : the_post();		if ( comments_open() || get_comments_number() ) :			comments_template();		endif;	endwhile; ?><?php get_footer(); ?>