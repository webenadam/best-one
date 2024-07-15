<?php

function send_email_to_pro_author_on_publish( $new_status, $old_status, $post ) {
    if ( 'pros' === $post->post_type && 'publish' === $new_status && $old_status !== $new_status ) {
        $author = get_userdata( $post->post_author );
        $email = $author->user_email;
        $first_name = $author->first_name;
        $last_name = $author->last_name;

        // Get the email subject and content template from ACF fields
        $subject = get_field('mail_pro_approved_mail_subject', 'option');
        $message_template = get_field('mail_pro_approved_mail_content', 'option');

        // Replace placeholders in the message template
        $message = str_replace(
            ['[שם_פרטי]', '[שם_משפחה]', '[מייל]'],
            [$first_name, $last_name, $email],
            $message_template
        );

        // Set content type to HTML
        add_filter( 'wp_mail_content_type', 'set_html_content_type' );

        wp_mail( $email, $subject, $message );

        // Reset content type to avoid conflicts
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    }
}

function set_html_content_type() {
    return 'text/html';
}

add_action( 'transition_post_status', 'send_email_to_pro_author_on_publish', 10, 3 );
