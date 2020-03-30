<?php
/**
 * Class SampleTest
 *
 * @package Mortgage
 */

class CSVから一括投稿するテスト extends WP_UnitTestCase {
  public $_post_id1;

  public function setUp() {
    // 投稿を作成
    $my_post1 = array(
      'post_title'    => '基礎知識編のカテゴリー記事',
      'post_name'     => 'existing_slug',
      'post_content'  => '基礎知識編のカテゴリー記事本文',
      'post_status'   => 'publish',
      'post_author'   => 1,
    );
    // 投稿をデータベースへ追加
    $this->_post_id1 = wp_insert_post( $my_post1 );
  }

  public function tearDown() {
    wp_delete_post( $this->_post_id1, true );
  }

  /**
   * @test
   * @group hoge
   */
  public function 配列から投稿を作成できる() {
    $row = ['hoge_slug', 'title name', '<div>this is contents</div>'];
    $post_id = createPostByArray($row);
    $this->assertTrue( is_int($post_id) );
  }

  /**
   * @test
   * @group hoge
   */
  public function 配列から既存の投稿を更新できる() {
    $row = ['existing_slug', 'title name', '<div>this is contents</div>'];
    $post_id = createPostByArray($row);
    $this->assertEquals( $this->_post_id1, $post_id );
  }
}
