<?php
/**
 * Class SampleTest
 *
 * @package Mortgage
 */

/**
 * Widget Test Case
 * @see https://site-manage.net/archives/1028
 */
class 指定のカテゴリーの記事一覧を表示するウィジェットのテスト extends WP_UnitTestCase {

  public $_category_id;
  public $_category_id_child;
  public $_category_id_child2;
  public $_category_id_other;
  public $_post_id1;
  public $_post_id2;

  public function setUp() {
    $this->_category_id = wp_create_category( '住宅ローンQ&A' );
    $this->_category_id_child = wp_create_category( '基礎知識編', $this->_category_id );
    $this->_category_id_child2 = wp_create_category( 'ウワサ編', $this->_category_id );
    // 投稿を作成
    $my_post1 = array(
      'post_title'    => '基礎知識編のカテゴリー記事',
      'post_content'  => '基礎知識編のカテゴリー記事本文',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_category' => array($this->_category_id_child)
    );
    // 投稿をデータベースへ追加
    $this->_post_id1 = wp_insert_post( $my_post1 );
    
    // 投稿を作成
    $my_post2 = array(
      'post_title'    => 'ウワサ編のカテゴリー記事',
      'post_content'  => 'ウワサ編のカテゴリー記事本文',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_category' => array($this->_category_id_child2)
    );
    // 投稿をデータベースへ追加
    $this->_post_id2 = wp_insert_post( $my_post2 );
  }

  public function tearDown() {
    wp_delete_category($this->_category_id);
    wp_delete_category($this->_category_id_child);
    wp_delete_category($this->_category_id_child2);
    wp_delete_post( $this->_post_id1, true );
    wp_delete_post( $this->_post_id2, true );
  }

  /**
   * @test
   */
  public function カテゴリーIDを渡すとそのカテゴリーの記事一覧を返すこと() {
    $custom_posts = get_posts_by_category_id($this->_category_id_child);
    while ( $custom_posts->have_posts() ) {
      $custom_posts->the_post();
      $this->assertEquals( $this->_category_id_child, get_the_category()[0]->term_id );
    }
  }

  /**
   * @test
   */
  public function カテゴリーIDの入力値が不正だった場合に不正と判定できる() {
    $this->assertEquals(false, Custom_Category_Widget::is_valid_list_string('1,hoge,3'));
  }

  /**
   * @test
   */
  public function カテゴリーIDの入力値に空白が入っていても正常だと判定する() {
    $this->assertEquals(true, Custom_Category_Widget::is_valid_list_string('1, 44 ,    66 '));
  }

  /**
   * @test
   */
  public function カテゴリーIDの入力値が空の場合正常だと判定する() {
    $this->assertEquals(true, Custom_Category_Widget::is_valid_list_string(''));
  }

  /**
   * @test
   */
  public function カテゴリーIDの保存時、カテゴリーIDが空白を含む場合除去して保存する() {
    $widget = new Custom_Category_Widget();
    $saved_instanse = $widget->update(['category_ids' => '1,2   ,3'], null);
    $this->assertEquals('1,2,3', $saved_instanse['category_ids']);
  }
}
