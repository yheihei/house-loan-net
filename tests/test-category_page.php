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
class カテゴリーページのテスト extends WP_UnitTestCase {

  public $_category_id;
  public $_category_id_child;
  public $_category_id_child2;

  public function setUp() {
    $this->_category_id = wp_create_category( '親カテゴリー' );
    $this->_category_id_child = wp_create_category( '子カテゴリー', $this->_category_id );
    $this->_category_id_child2 = wp_create_category( '孫カテゴリー', $this->_category_id_child );
  }

  public function tearDown() {
    wp_delete_category($this->_category_id);
    wp_delete_category($this->_category_id_child);
    wp_delete_category($this->_category_id_child2);
  }

  /**
   * @test
   */
  public function パンくずリストの一番子のカテゴリーを取得できること() {
    $this->go_to( get_category_link( $this->_category_id_child2 ) );
    $categorys = get_categorys_for_breadcrumb();
    $this->assertEquals( $this->_category_id_child2, $categorys[2]->cat_ID );
  }

  /**
   * @test
   */
  public function パンくずリスト、カテゴリーが一番親の時、親だけ返すこと() {
    $this->go_to( get_category_link( $this->_category_id ) );
    $categorys = get_categorys_for_breadcrumb();
    $this->assertEquals( $this->_category_id, $categorys[0]->cat_ID );
  }

  /**
   * @test
   */
  public function パンくずリスト、カテゴリーページでない時空を返すこと() {
    $this->go_to( '/' );
    $categorys = get_categorys_for_breadcrumb();
    $this->assertEquals( true, empty($categorys) );
  }
}
