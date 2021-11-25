# YoBro WordPress Private Messaging Plugin Email Notifications
A simple implementation to send email notifications for the YoBro plugin 

## Requirements
- [YoBro plugin v2.4](https://codecanyon.net/item/yobro-wordpress-multi-user-private-messaging-plugin/20563304)
- WordPress 5.8+
- Access to MySQL database
- Working WP email configuration
- [Code Snippets Plugin](https://wordpress.org/plugins/code-snippets/)

### Functionality
This code uses the "yobro_after_store_message "and "yobro_new_conversation_created" actions to send a notification email to the sender or receiver. An email will be sent for each message; grouping could be useful in a future update.

### Set up

 - Add a new tinytext column to your "yobro_messages" called "email_sent"
 - Create a new Code Snippet that runs everywhere, paste the php from the file
