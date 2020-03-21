
<?php get_header(); ?>

<div id="main">
<div id="content">
<?php
  $bread_categorys = get_categorys_for_breadcrumb();
  if ( $bread_categorys ) :
    // パンくずリスト
?>
  <section class="bread bread--category">
    <ol itemscope itemtype="http://schema.org/BreadcrumbList">
      <li itemprop="itemListElement" itemscope
  itemtype="http://schema.org/ListItem">
        <a href="<?php echo home_url(); ?>" itemprop="item">
          <span itemprop="name">HOME</span>
        </a> >
        <meta itemprop="position" content="1" />
      </li>
      <?php 
        foreach( $bread_categorys as $index => $bread_category ) :
      ?>
          <li itemprop="itemListElement" itemscope
      itemtype="http://schema.org/ListItem">
            <a href="<?php echo get_category_link( $bread_category->cat_ID )  ?>" itemprop="item">
              <span itemprop="name"><?= $bread_category->name; ?></span>
            </a>
            <meta itemprop="position" content="<?php echo $index+2 ?>" />
            <?php 
              if( count($bread_categorys) !== $index+1 ) {
                // 最後のカテゴリーでない時、矢印を出力
                echo '>';
              }
            ?>
          </li>
        <?php endforeach; ?>
    </ol>
  </section>
<?php
  endif; // パンくずリスト
?>
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