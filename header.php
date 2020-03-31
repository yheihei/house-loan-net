<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head profile="http://gmpg.org/xfn/11">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="author" content="" />
<meta name="keyword" content="" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
<!-- <meta name="description" content="何も考えずに銀行や不動産会社の言うままに住宅ローンを組むと非常に大きな損失が生じます！最も賢く選んで頂くために金利をはじめ、各銀行の住宅ローンについて調査しています。" /> -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); //bodyタグにページの種類に応じたクラス名を与える ?>>

<div id="base">
  <div id="header">
    <h1><a href="<?php echo home_url(); ?>"><img class="header_logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?>" /></a></h1>
  </div>
  <!--/header end-->