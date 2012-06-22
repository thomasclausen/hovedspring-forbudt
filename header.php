<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]><html class="no-js ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->

<head>
<title><?php wp_title( '', true, 'right' ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="description" content="" />
<meta property="og:description" content="" />
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/logo-facebook.jpg">
<link rel="image_src" href="<?php echo get_template_directory_uri(); ?>/images/logo-facebook.jpg" />
<?php wp_head(); ?>
<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<body <?php body_class(); ?>>
	<header><a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a></header>