<?php
/**
 * The template used for displaying post and page content
 *
 * @package WordPress
 * @subpackage HOVEDSPRING FORBUDT
 * @since v0.1
 */
?>

		<?php if ( get_post_type() == 'page' ) : the_title( '<h1>', '</h1>' ); else : the_title( '<h2>' . __( 'FAKTA ', 'hovedspring-forbudt' ), '</h2>' ); endif; ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_content(); ?>
			<?php if ( get_post_type() == 'post' && is_user_logged_in() ) : ?><div id="update-icon"></div><?php endif; ?>
		</article>
