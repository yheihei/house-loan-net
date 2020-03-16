<?php get_header(); ?>

<div id="main">
<div id="content">
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>

    <section <?php post_class(); ?>>
      <h1 class="post-title post-title--primary"><?php the_title();  ?></h1>
      <div class="box_out">
        <div class="box_in">
          <?php the_content();  ?>
        </div>
      </div>
    </section>

  <?php endwhile; // 繰り返し終了 ?>
<?php else : // 条件分岐：投稿が無い場合は ?>

  <h2>投稿が見つかりません。</h2>

<?php endif; // 条件分岐終了 ?>


</div><!-- /content -->

<div id="side">
  <?php get_sidebar(); //sidebar.phpを取得 ?>
</div><!-- #side -->

<?php get_footer();