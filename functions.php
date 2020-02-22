<?php

/**
 * ウィジェットエリアを定義します。
 */
register_sidebar(array(
  'name'          => 'サイドバー',
  'id'            => 'primary-widget-area',
  'description'   => 'サイドバーに表示されるウィジェットエリアです。',
  'before_widget' => '<div id="%1$s" class="widget sideBlock %2$s">',
  'after_widget'  => '</div>',
  'before_title'  => '<h3 class="widget-title">',
  'after_title'   => '</h3>',
));