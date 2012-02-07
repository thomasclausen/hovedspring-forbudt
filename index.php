<?php $theme_post_type = get_post_type(); // post, page, attachment etc. ?>
<?php $theme_post_format = get_post_format(); // standard, gallery, link, status etc. ?>

<?php get_header( $theme_post_type ); ?>

	<section class="page">
		<?php if ( is_single() ) : ?>
			<?php $args = array( 'page_id' => 1 );
			$front_page = new WP_Query( $args );
			while ( $front_page->have_posts() ) : $front_page->the_post();
				get_template_part( 'content', $theme_post_format );
			endwhile; ?>
		<?php else : ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', $theme_post_format ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php endif; ?>
	</section>
	<section class="post">
		<?php if ( is_single() ) : ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', $theme_post_format ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php else : ?>
			<?php $args = array( 'post_type' => 'post', 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page' => 1 );
			$random_facts = new WP_Query( $args );
			while ( $random_facts->have_posts() ) : $random_facts->the_post();
				get_template_part( 'content', $theme_post_format );
			endwhile; ?>
		<?php endif; ?>
		<nav>
			<a href="<?php echo home_url(); ?>" title="Vis ny fakta" id="update">Vis ny fakta</a>
			<a href="#/permalink" title="Direkte link" id="permalink" class="social">Direkte link</a>
			<a href="#/twitter" title="Twitter" id="twitter" class="social">Twitter</a>
			<a href="#/facebook" title="Facebook" id="facebook" class="social">Facebook</a>
			<a href="#/googleplus" title="Google Plus" id="google" class="social">Google Plus</a>
		</nav>
	</section>

<?php get_footer( $theme_post_type ); ?>
