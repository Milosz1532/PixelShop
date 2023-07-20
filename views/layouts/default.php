<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel CMS</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <?php
        include_once("views/includes/navigation.php");
    ?>
    <!-- POPUP NOTIFICATION -->
    <div class="popup-notification">
                <div class="content">
                    
                    <i class="fa-solid fa-triangle-exclamation"></i><span class="title"></span>
                    <p class="message"></p>
                </div>
            </div>
            <!-- END POPUP NOTIFICATION -->
    <div class="App">
        <main>
            <?php include_once("views/includes/header.php"); ?>
            <section class="container-fluid main-container">
                <?php echo $content ?>
            </section>
        </main>
    </div>

    <script src="./assets/js/main.js"></script>
</body>
</html>
