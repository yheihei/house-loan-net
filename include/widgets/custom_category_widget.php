<?php

class Custom_Category_Widget extends WP_Widget{
  /**
   * Widgetを登録する
   */
  function __construct() {
    parent::__construct(
      'Custom_Category_Widget', // Base ID
      'カスタムカテゴリー一覧', // Name
      array( 'description' => '任意のカテゴリーの記事一覧を表示します', ) // Args
    );
  }

  /**
   * 表側の Widget を出力する
   *
   * @param array $args      'register_sidebar'で設定した「before_title, after_title, before_widget, after_widget」が入る
   * @param array $instance  Widgetの設定項目
   */
  public function widget( $args, $instance ) {
    $title = $instance['title'];
    $category_ids_string = $instance['category_ids'];
    echo $args['before_widget'];
    $title_class = isset($instance['title_class']) ? $instance['title_class'] : '';
    $before_title = sprintf( $args['before_title'], $title_class );
    echo $before_title;
    echo esc_html( $instance['title'] );
    echo $args['after_title'];

    // 指定したカテゴリーのカテゴリー名と記事一覧を表示
    echo <<<EOM
<div class="side_box">
  <div class="side_inbox">
EOM;
    $term_ids = explode( ',', $category_ids_string );
    foreach( $term_ids as $term_id ) :
      $custom_posts = get_posts_by_category_id( $term_id );
      echo "<p class='catName'>". get_cat_name( $term_id ) . "</p>";
      echo "<ul>";
      while ( $custom_posts->have_posts() ) :
        $custom_posts->the_post();
        echo "<li><a href='". get_the_permalink() ."'>". get_the_title() . "</a></li>";
      endwhile;
      echo "</ul>";
    endforeach;
    echo <<<EOM
  </div>
</div>
EOM;
    echo $args['after_widget'];
  }

  /** Widget管理画面を出力する
   *
   * @param array $instance 設定項目
   * @return string|void
   */
  public function form( $instance ){
    // タイトルの保存フィールド
    $title = $instance['title'];
    $title_name = $this->get_field_name('title');
    $title_id = $this->get_field_id('title');
    ?>
    <p>
      <label for="<?php echo $title_id; ?>">タイトル:</label>
      <input class="widefat" id="<?php echo $title_id; ?>" name="<?php echo $title_name; ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="ウィジェットに表示するタイトル">
    </p>

    <?php
    // タイトルに付与するclassの保存フィールド
    $title_class = $instance['title_class'];
    $title_class_name = $this->get_field_name('title_class');
    $title_class_id = $this->get_field_id('title_class');
    ?>
    <p>
      <label for="<?php echo $title_class_id; ?>">タイトルのclass:</label>
      <input class="widefat" id="<?php echo $title_class_id; ?>" name="<?php echo $title_class_name; ?>" type="text" value="<?php echo esc_attr( $title_class ); ?>" placeholder="タイトルに付与するclass名">
    </p>

    <?php

    // カテゴリーIDの保存フィールド
    $category_ids = $instance['category_ids'];
    $category_ids_name = $this->get_field_name('category_ids');
    $category_ids_id = $this->get_field_id('category_ids');
    ?>
    <p>
      <label for="<?php echo $category_ids_id; ?>">表示したい記事一覧のカテゴリーID:</label>
      <input class="widefat" id="<?php echo $category_ids_id; ?>" name="<?php echo $category_ids_name; ?>" type="text" value="<?php echo esc_attr( $category_ids ); ?>" placeholder="1,3,55 (カンマ区切りでカテゴリーIDを入力)">
    </p>
    <?php
  }

  /** 新しい設定データが適切なデータかどうかをチェックする。
   * 必ず$instanceを返す。さもなければ設定データは保存（更新）されない。
   *
   * @param array $new_instance  form()から入力された新しい設定データ
   * @param array $old_instance  前回の設定データ
   * @return array               保存（更新）する設定データ。falseを返すと更新しない。
   */
  function update($new_instance, $old_instance) {
    if( !self::is_valid_list_string($new_instance['category_ids']) ) {
      return false;
    }
    // 半角スペース、全角スペース除去
    $new_instance['category_ids'] = preg_replace("/( |　)/", "", $new_instance['category_ids'] );
    return $new_instance;
  }

  /**
   * カンマ区切り("1,3,5"など)で数値のリストに変換できるかを判定する
   * @param strign $list_string
   * @return bool
   */
  static function is_valid_list_string($list_string) {
    if(!$list_string) {
      // 空白の場合正常値と判定
      return true;
    }
    $lists = explode(",", $list_string);
    foreach( $lists as $list ) {
      if( !intval(trim($list)) ) {
        // 数値に変換できない場合
        return false;
      }
    }
    return true;
  }
}