<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signin</title>
    <?php require("ajax_post.php"); ?>
</head>
<body>
<h1>Signin</h1>
<?php echo form_open('',$form_data['attributes']); ?>
<div>
    <?php echo form_label('Email', $form_data['email']['id']); ?>
    <?php echo form_input($form_data['email']); ?>
</div>
<div>
    <?php echo form_label('Password', $form_data['password']['id']); ?>
    <?php echo form_password($form_data['password']); ?>
</div>
<div>
    <?php echo form_submit('submit', 'Signin'); ?>
</div>
<?php echo form_close(); ?>
</body>
</html>
