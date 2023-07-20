<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/employees.css">
</head>

<body>
    <div class="tab-title emp-config">
        <span class="material-icons">edit</span>
        <h3>Zarządzanie pracownikiem</h3>
    </div>

    <div class="config-box mt-4">
        <h5 class="title">Dodaj pracownika</h5>
        <div class="row mt-4">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Login</p>
                    <input id="login" name="login" type="text" placeholder="Wprowadz login...">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Imię</p>
                    <input id="firstName" name="firstName" type="text" placeholder="Wprowadz imię...">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Nazwisko</p>
                    <input id="lastName" name="lastName" type="text" placeholder="Wprowadz nazwisko...">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>E-mail</p>
                    <input id="email" name="email" type="text" placeholder="Wprowadz e-mail...">
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Numer telefonu</p>
                    <input id="phoneNumber" name="phoneNumber" type="text" maxlength="10"
                        placeholder="Wprowadz numer telefonu...">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Data urodzenia</p>
                    <input id="birthday" name="birthday" type="date">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Miasto</p>
                    <input id="city" name="city" type="text" placeholder="Wprowadz miasto...">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="accountType" name="accountType">
                <label class="form-check-label" for="accountType">Uprawnienia administratora</label>
            </div>
        </div>
        <div class="row mt-4">
            <div class="buttons">
                <button id="cancelButton" class="config-button">Anuluj</button>
                <button id="submitButton" class="config-button">Utwórz konto</button>
            </div>
        </div>
    </div>


    <script src="./assets/js/employees.js"></script>
</body>