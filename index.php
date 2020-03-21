
<?php get_header(); ?>

<div id="main">
<div id="content">
<?php if ( have_posts() ) : ?>
  <?php get_template_part( 'templates/archives' ); ?>
<?php else : // 条件分岐：投稿が無い場合は ?>

  <h2>投稿が見つかりません。</h2>

<?php endif; // 条件分岐終了 ?>


</div><!-- /content -->

     <div id="side">
     <?php get_sidebar(); //sidebar.phpを取得 ?>
  </div><!--/side end-->

<?php get_footer();