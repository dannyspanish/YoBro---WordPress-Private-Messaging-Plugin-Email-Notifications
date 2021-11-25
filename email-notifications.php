<?php

// User to user notification
add_action("yobro_after_store_message", function($message){
global $wpdb;
    $id = $message['id'];
    $conv_id = $message['conv_id'];
    $sender_id = $message['sender_id'];
    $reciever_id = $message['reciever_id'];
    $conversation_table = $wpdb->prefix . "yobro_conversation";
    $convo_details = $wpdb->get_results( 
        $wpdb->prepare( "
            SELECT * FROM **TABLE PREFIX**_yobro_conversation //Enter your table prefix
            WHERE id =" . $conv_id
                      ) 
    );
    $sender = array_column($convo_details, 'sender');
    $receiver = array_column($convo_details, 'reciever');
    
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $message_content =  $message['message'];
    $formattedmessage = strip_tags($message_content);
    $finalmessage = 'Hi, you\'ve received a new message:' . '<br>' . $message_content . '<br>';
    $ids = $message['sender_id'] . $message['reciever_id'];

    // I found that the messages table can sometimes have the same ids for both
    if ($sender_id == $reciever_id){
        $user_info = get_userdata($sender[0]);
        $email = $user_info->user_email;
        wp_mail( $email, 'New message recevied', $finalmessage, $headers); // send the email
        
    } else{
            $user_info = get_userdata($message['reciever_id']);
            $email = $user_info->user_email;
            wp_mail( $email, 'New message recevied', $finalmessage, $headers ); // send the email
    }
    //Enter your table prefix
    $wpdb->query($wpdb->prepare("UPDATE  _yobro_messages SET email_sent='1' WHERE id=$id")); 

});


// New conversation created
add_action("yobro_new_conversation_created", function($message){
global $wpdb;
$message_table = $wpdb->prefix . "yobro_messages";
$sender_messages = $wpdb->get_results( 
    //Enter your table prefix
    $wpdb->prepare( "
        SELECT sender_id FROM _yobro_messages
        WHERE email_sent IS NULL"
    ) 
);

$receiver_messages = $wpdb->get_results( 
    //Enter your table prefix
    $wpdb->prepare( "
        SELECT * FROM _yobro_messages 
        WHERE email_sent IS NULL"
    ) 
);

    if($receiver_messages) {
        foreach($receiver_messages as $receiver_message) {
            $message_id = $receiver_message->id;
            $user_info = get_userdata($receiver_message->reciever_id);
            $email = $user_info->user_email;
            $message_content =  'Someone has sent you a message.';
            wp_mail( $email, 'New message recevied', $message_content ); // Send the email
               //Enter your table prefix
            $wpdb->query($wpdb->prepare("UPDATE  _yobro_messages SET email_sent='1' WHERE id=$id")); 
        }
    } else {
        //
    }
});

?>
