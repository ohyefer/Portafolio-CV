<?php

  $receiving_email_address = 'bravoluquey@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include($php_email_form);
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->reply_to = $_POST['email'];
  $contact->subject = $_POST['subject'];

  $contact->add_message($_POST['message'], '');

  echo $contact->send();
?>
