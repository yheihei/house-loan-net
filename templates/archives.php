<?php while ( have_posts() ) : the_post(); ?>
  <section <?php post_class(); ?>>
    <h1 class="post-title post-title--primary"><?php the_title();  ?></h1>
    <div class="box_out">
      <div class="box_in">
        <?php the_content(); ?>
      </div>
    </div>
  </section>
<?php endwhile; // 繰り返し終了 ?>
<?php the_posts_pagination(); ?>