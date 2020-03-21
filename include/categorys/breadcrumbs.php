<?php

function get_categorys_for_breadcrumb() {
  // 現在のページのカテゴリー情報を取得
  $current_category = get_queried_object();
  if( !$current_category ) {
    // カテゴリーページじゃない場合空を返す
    return [];
  }

  $bread_categorys = [];
  if ( $current_category->parent != 0 ) {
    // 指定したカテゴリIDの祖先IDを配列で取得（子、親、祖先順）
    $ancestor_category_ids = get_ancestors($current_category->cat_ID, 'category');  
    // 祖先から表示したいので、上の配列を逆にソート（祖先、親、子順）
    $ancestor_category_ids = array_reverse($ancestor_category_ids);
    foreach( $ancestor_category_ids as $ancestor_category_id ) {
      $ancestor_category = get_category( $ancestor_category_id );
      $bread_categorys[] = $ancestor_category;
    }
  }
  $bread_categorys[] = $current_category;
  return $bread_categorys;
}