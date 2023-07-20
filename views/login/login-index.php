<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie do systemu</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>

</head>

<body>
    <!-- POPUP NOTIFICATION -->
    <div class="popup-notification">
                <div class="content">
                    
                    <i class="fa-solid fa-triangle-exclamation"></i><span class="title"></span>
                    <p class="message"></p>
                </div>
            </div>
            <!-- END POPUP NOTIFICATION -->

    <div class="container">
        <div class="login-box">
            <div class="top">
                <div class="image-box">
                    <img src="./assets/images/logo2.png" alt="Logo">
                </div>
                <h4>Logowanie do systemu</h4>
                <p>Panel administracyjny</p>
            </div>
            <div class="errorBox">
                <span class="material-icons">
                    error_outline
                </span>
                <span class="error-message"> Wystąpił błąd</span>
            </div>
            <div class="login-form" id="step-1">
                <div class="input-design">
                    <p>Login: </p>
                    <input id="loginInput" type="text" placeholder="Wprowadź login...">
                </div>

                <button class="step1-submit">Dalej</button>
            </div>
            <div class="login-form step-2">
                <p class="loginTitle">Witaj <span></span></p>
                <div class="input-design">
                    <p>Hasło: </p>
                    <input id="passwordInput" type="password" placeholder="Wprowadź hasło...">
                </div>
                <button class="step2-submit">Zaloguj się</button>
                <button class="backButton" id="backPassword">Cofnij</button>
            </div>
            <div class="login-form step-3">
                <p class="activateTitle">Aktywacja konta <span></span></p>
                <div class="input-design">
                    <p>Hasło: </p>
                    <input id="activatePassword"type="password" placeholder="Wprowadź hasło...">
                </div>
                <div class="input-design">
                    <p>Powtórz hasło: </p>
                    <input id="confirmActivatePassword" type="password" placeholder="Wprowadź ponownie hasło...">
                </div>

                <button class="activate-submit">Aktywuj konto</button>
                <button class="backButton" id="backActivation">Cofnij</button>
            </div>
        </div>
    </div>

    <script src="./assets/js/main.js"></script>

    <script src="./assets/js/login.js"></script>
</body>

</html>