<?php

function send_email_to_pro_author_on_publish( $new_status, $old_status, $post ) {
    if ( 'pros' === $post->post_type && 'publish' === $new_status && $old_status !== $new_status ) {
        $author = get_userdata( $post->post_author );
        $email = $author->user_email;
        $subject = 'Your post has been published';
        $message = 'Hi ' . $author->display_name . ",\n\n" .
                   'Your post, "' . $post->post_title . '" has been published.' . "\n\n" .
                   'You can view it here: ' . get_permalink( $post );

        wp_mail( $email, $subject, $message );
    }
}
add_action( 'transition_post_status', 'send_email_to_pro_author_on_publish', 10, 3 );
