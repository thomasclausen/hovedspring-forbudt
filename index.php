<?php $hovedspring_forbudt_post_type = get_post_type(); ?>
<?php $hovedspring_forbudt_post_format = get_post_format(); ?>

<?php get_header( $hovedspring_forbudt_post_type ); ?>

	<section class="page">
		<?php if ( is_single() ) : ?>
			<?php $args = array( 'page_id' => 1 );
			$front_page = new WP_Query( $args );
			while ( $front_page->have_posts() ) : $front_page->the_post();
				get_template_part( 'content', $hovedspring_forbudt_post_format );
			endwhile; ?>
		<?php else : ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', $hovedspring_forbudt_post_format ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php endif; ?>
	</section>
	<section class="fakta">
		<?php if ( is_single() ) : ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', $hovedspring_forbudt_post_format ); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php else : ?>
			<?php $args = array( 'post_type' => 'fakta', 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page' => 1 );
			$random_fact = new WP_Query( $args );
			while ( $random_fact->have_posts() ) : $random_fact->the_post();
				get_template_part( 'content', $hovedspring_forbudt_post_format );
			endwhile; ?>
		<?php endif; ?>
		<nav>
			<a href="<?php echo home_url(); ?>" title="<?php _e( 'Vis ny fakta', 'hovedspring-forbudt' ); ?>" id="update"><?php _e( 'Vis ny fakta', 'hovedspring-forbudt' ); ?></a>
			<a href="#/permalink" title="<?php _e( 'Direkte link', 'hovedspring-forbudt' ); ?>" id="permalink" class="social"><?php _e( 'Direkte link', 'hovedspring-forbudt' ); ?></a>
			<a href="#/twitter" title="<?php _e( 'Twitter', 'hovedspring-forbudt' ); ?>" id="twitter" class="social"><?php _e( 'Twitter', 'hovedspring-forbudt' ); ?></a>
			<a href="#/facebook" title="<?php _e( 'Facebook', 'hovedspring-forbudt' ); ?>" id="facebook" class="social"><?php _e( 'Facebook', 'hovedspring-forbudt' ); ?></a>
			<a href="#/googleplus" title="<?php _e( 'Google Plus', 'hovedspring-forbudt' ); ?>" id="google" class="social"><?php _e( 'Google Plus', 'hovedspring-forbudt' ); ?></a>
		</nav>
	</section>

<?php get_footer( $hovedspring_forbudt_post_type ); ?>
