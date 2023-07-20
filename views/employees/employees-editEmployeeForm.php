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
        <h5 class="title">Edytuj pracownika</h5>
        <div class="row mt-4">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Login</p>
                    <input id="login" name="login" type="text" placeholder="Wprowadz login..."
                        value="<?php echo $employee->getLogin() ?>">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Imię</p>
                    <input id="firstName" name="firstName" type="text" placeholder="Wprowadz imię..."
                        value="<?php echo $employee->getFirstName() ?>">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Nazwisko</p>
                    <input id="lastName" name="lastName" type="text" placeholder="Wprowadz nazwisko..."
                        value="<?php echo $employee->getLastName() ?>">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>E-mail</p>
                    <input id="email" name="email" type="text" placeholder="Wprowadz e-mail..."
                        value="<?php echo $employee->getEmail() ?>">
                </div>
            </div>


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Numer telefonu</p>
                    <input id="phoneNumber" name="phoneNumber" type="text" maxlength="10"
                        placeholder="Wprowadz numer telefonu..." value="<?php echo $employee->getPhoneNumber() ?>">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Data urodzenia</p>
                    <input id="birthday" name="birthday" type="date" value="<?php echo $employee->getBorn() ?>">
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 ">
                <div class="config-input obligatory">
                    <p>Miasto</p>
                    <input id="city" name="city" type="text" placeholder="Wprowadz miasto..."
                        value="<?php echo $employee->getCity() ?>">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="accountType" name="accountType" <?php echo
                    $employee->getIsAdmin() ? "checked" : false ?> >
                <label class="form-check-label" for="accountType">Uprawnienia administratora</label>
            </div>
        </div>

        <div class="row mt-4">
            <div class="buttons">
                <button id="cancelButton" class="config-button">Anuluj</button>
                <div>
                    <button id="resetPasswordButton" data-employeeId="<?php echo $employee->getId(); ?>"
                        class="config-button reset mr-2">Resetuj hasło</button>
                    <button id="deleteAccount" data-employeeId="<?php echo $employee->getId(); ?>"
                        class="config-button reset mr-2">Usuń konto</button>
                    <button id="submitButton" class="config-button" data-employeeId="<?php echo $employee->getId(); ?>">Edytuj konto</button>
                </div>

            </div>
        </div>
    </div>


    <script src="./assets/js/employees.js"></script>
</body>