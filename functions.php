<?php

/**
 * ウィジェットエリア定義
 */
include_once 'include/widgets/custom_category_widget.php';
add_action( 'widgets_init', function () {
  register_widget( 'Custom_Category_Widget' );  // カスタムカテゴリーウィジェット
  register_sidebar(array(
    'name'          => 'サイドバー',
    'id'            => 'primary-widget-area',
    'description'   => 'サイドバーに表示されるウィジェットエリアです。',
    'before_widget' => '<div id="%1$s" class="widget sideBlock %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));
} );

/**
 * カテゴリーIDを渡すとそのカテゴリーの記事一覧を返すこと
 * @param int $term_id カテゴリーのID
 * @return array 記事一覧
 */
function get_posts_by_category_id( $term_id ) {
  $args = ['cat' => $term_id];
  return new WP_Query($args);
}

/**
 * 管理画面にカテゴリーIDを表示する
 */
function add_category_columns($columns) {
    $index = 1; // 追加位置
    return array_merge(
        array_slice($columns, 0, $index),
        array('id' => 'ID'),
        array_slice($columns, $index)
    );
}
add_filter('manage_edit-category_columns', 'add_category_columns');
function add_category_custom_fields($deprecated, $column_name, $term_id) {
    if ($column_name == 'id') {
        echo $term_id;
    }
}
add_action('manage_category_custom_column', 'add_category_custom_fields', 10, 3);

/**
 * 続きを読むリンクの変更
 */
function modify_read_more_link() {
  return '<a class="more-link more-link--primary" href="' . get_permalink() . '">続きを読む</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * カテゴリーページ設定読み込み
 */
include_once 'include/categorys/breadcrumbs.php';

/**
 * 投稿インポートページ読み込み
 */
include_once 'include/import/post.php';

/**
 * 記事編集ページカスタマイズ機能読み込み
 */
include_once 'include/posts/edit.php';


function my_log($message) {
  $log_message = sprintf("%s:%s\n", date_i18n('Y-m-d H:i:s'), $message);
  $file_name = WP_CONTENT_DIR . '/logs/my_output_' . date_i18n('Y-m-d')  . '.log';
  error_log($log_message, 3, $file_name);
}