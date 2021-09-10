
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <form action="options.php" method="post">
        <?php
            settings_errors();
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );
            submit_button('Enregistrer'); ?>
    </form>
</div> 
    
</body>
</html>
