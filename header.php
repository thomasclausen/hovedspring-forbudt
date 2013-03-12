<!DOCTYPE html>
<!--[if lt IE 8]><html class="no-js ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
<title><?php wp_title( '', true, 'right' ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header><a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a></header>