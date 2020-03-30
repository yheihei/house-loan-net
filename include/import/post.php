<?php 

// 管理メニューに追加するフック
add_action('admin_menu', 'mortgage_add_pages');
function mortgage_add_pages() {
  // 「ツール」下に新しいサブメニューを追加
  add_management_page( __('CSVから記事をインポート','menu-mortgage-import'), __('CSVから記事をインポート','menu-mortgage-import'), 'manage_options', 'testtools', 'mortgage_import_page');
}
// mortgage_import_page() は CSVから記事をインポート サブメニューのページコンテンツを表示
function mortgage_import_page() { ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <h2>CSVをアップし 記事を一括作成</h2>
  <div class="form-group">
    <form method="post" action="" enctype="multipart/form-data">
      <label for="htmlTemplate">CSVを選択してアップロードを押してください</label>
      <input type="file" name="upfilename" style="margin-bottom:2rem;" />
      <input class="button button-primary" type="submit" value="アップロード">
      <input class="form-control" type="hidden" name="submit[regist_file_up]" value="on">
    </form>
  </div>
<?php
}

/**
 * CSVアップロード時の挙動
 * */
add_action('init', 'doCreatePostsByCsv' );

/**
 * CSV uploadがきたら記事を投稿する
 * */
function doCreatePostsByCsv() {
  my_log(__METHOD__ . "-START");
  if (isset($_REQUEST["submit"]["regist_file_up"])) {
    try {
      //ファイルアップロード処理
      $uploadedFilePath = registFileUp();
      
      // CSVを取得し、投稿内容を得る
      $posts = getCsvToArray($uploadedFilePath, 'sjis');
      
      if( empty($posts) ) {
        my_log("記事データがありません");
        return;
      }
      
      // 投稿内容から、記事を作成する
      foreach($posts as $single_post) {
        createPostByArray($single_post);
      }
      my_log( '記事が投稿されました' );
    } catch (\Exception $exception) {
      my_log( $exception->getTraceAsString() );
      return;
    }
  }
  my_log(__METHOD__ . "-END");
}

/**
 * ファイルアップロード処理
 * @return string uploaded file path
 * */
function registFileUp(){
  //CSVファイルがアップロードされた場合
  if (is_uploaded_file($_FILES["upfilename"]["tmp_name"])) {
    $upload_dir = wp_upload_dir();
    $upload_file_name = $upload_dir['basedir'] . "/" . $_FILES["upfilename"]["name"];
    if (move_uploaded_file($_FILES["upfilename"]["tmp_name"], $upload_file_name)) {
        chmod($upload_file_name, 0777);
    }
    $message = "ファイルをアップロードいたしました";
    return $upload_file_name;
  }
  $message = "ファイルのアップロードが失敗しました";
  return '';
}

/**
 * CSVローダー
 *
 * @param string $csvfile CSVファイルパス
 * @param string $mode `sjis` ならShift-JISでカンマ区切り、 `utf16` ならUTF-16LEでタブ区切りのCSVを読む。'utf8'なら文字コード変換しないでカンマ区切り。
 * @return array ヘッダ列をキーとした配列を返す
 */
function getCsvToArray($csvfile, $mode='sjis')
{
  $records = [];
  if (($handle = fopen($csvfile, "r")) !== FALSE) {
    // 1行ずつfgetcsv()関数を使って読み込む
    while (($data = fgetcsv($handle))) {
      $records[] = $data;
      foreach ($data as $value) {
          echo "「${value}」\n";
      }
    }
    fclose($handle);
  }
  return $records;
}

function createPostByArray($row) {
  $post_id = 0;
  $post_param = array(
    'post_title'    => $row[1],
    'post_name' => $row[0], // スラグ
    'post_content'  => $row[2],
    'post_status'   => 'publish',
    'post_author' => \get_current_user_id(),
    // 'post_category' => array( get_cat_ID($post['カテゴリ']) ),
  );

  $existing_post_id = getPostIDBySlug($row[0]);
  if( $existing_post_id ) {
    $post_param['ID'] = $existing_post_id;
    // 投稿を更新する
    $post_id = \wp_update_post( $post_param );
  } else {
    // 投稿を新規追加する
    $post_id = \wp_insert_post( $post_param, false );
  } 
  return $post_id;
}

function getPostIDBySlug( $slug ) {
  $wpPostObjects = get_posts( "name=".$slug );
  if(empty($wpPostObjects)) return 0;
  return $wpPostObjects[0]->ID;
}