<?php

/**
 * 投稿編集画面に記事下コンテンツの入力Formを追加
 */
function after_post_content_meta_box() {
  add_meta_box(
    'after-post-content',
    '記事下コンテンツ',
    'after_post_content_meta_box_callback',
    'post',
    'normal'
  );
}
add_action( 'add_meta_boxes', 'after_post_content_meta_box' );
function after_post_content_meta_box_callback( $post ) {
  // Add a nonce field so we can check for it later.
  wp_nonce_field( 'after_post_content_nonce', 'after_post_content_nonce' );
  $value = get_post_meta( $post->ID, '_after_post_content', true );
// ↓で入力Formを表示 ?>
  <textarea id="after_post_content" name="after_post_content" rows="10" cols="100"><?php echo esc_attr( $value ); ?></textarea>
<?php
  // echo '<input style="width:100%" id="after_post_content" name="after_post_content" value="'. esc_attr( $value ) . '" placeholder="1,3,88">';
}
/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_after_post_content_meta_box_data( $post_id ) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['after_post_content_nonce'] ) ) {
    return;
  }
  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['after_post_content_nonce'], 'after_post_content_nonce' ) ) {
    return;
  }
  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  // Check the user's permissions.
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }
  }
  else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
  }

  /* OK, it's safe for us to save the data now. */
  // Make sure that it is set.
  if ( ! isset( $_POST['after_post_content'] ) ) {
    return;
  }

  // Update the meta field in the database.
  update_post_meta( $post_id, '_after_post_content', $_POST['after_post_content'] );
}
add_action( 'save_post', 'save_after_post_content_meta_box_data' );

 