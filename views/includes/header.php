<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <section class="top-section">
        <div class="toggle-nav">
            <span class="material-icons">menu</span>
        </div>
        <div class="logo">
            <img src="./assets//images/logo2.png" alt="logo">
            <span>Pixel</span>
        </div>
        <div class="account">
            <div class="info-box">
                <?php
                    $session = new Session();
                    $sessionData = $session->get('userData');
                    echo '<span class="name">Hey, <strong>'.$sessionData['firstName'].'</strong></span>';
                    if ($sessionData['accountType'] == 1 ) {
                        echo '<span class="accountType">Admin</span>';
                    }else {
                        echo '<span class="accountType">Użytkownik</span>';
                    }
                ?>   
            </div>
            <div class="icon">
            <?php
                $first = strtoupper(substr($sessionData['firstName'], 0, 1));
                $second = strtoupper(substr($sessionData['lastName'], 0, 1));
                echo "<span>".$first."".$second."</span>";
            ?>
            </div>
        </div>
    </section>
</body>
</html>