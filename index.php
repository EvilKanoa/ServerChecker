<!DOCTYPE html>
<?php include 'includes/untils.php'; ?>
<html>
    <head>
        <title>MC Server Checker</title>
        <link href="stylesheet.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <div id="container">
            <h1 id="header">Servers</h1>
            
            <p class="warning">This is not finished yet!</p>
            <?php echo getHTMLForAllServers(); ?>
        </div>
    </body>
</html>