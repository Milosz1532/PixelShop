<!DOCTYPE html>
<html lang="pl">

<head>
    <link rel="stylesheet" href="./assets/css/employees.css">
</head>

<body>
    <div class="tab-title">
        <span class="material-icons">diversity_3</span>
        <h3>Pracownicy</h3>
    </div>



    <div class="row">
        <div class="employees-box-button">
            <h5 class="employees-box-title">Lista pracowników</h5>
            <a href="index.php?section=employees&action=addEmployeeForm"><button class="addEmployees">Dodaj <span
                        class="material-icons">add</span></button></a>
        </div>
    </div>
    <div class="row">
        <div class="employees-box">
            <div class="row">
                <?php
                    foreach($employees as $employee) {
                        $name = $employee->getFirstName().' '.$employee->getLastName();
                        $icon = strtoupper(substr($employee->getFirstName(), 0, 1)).''.strtoupper(substr($employee->getLastName(), 0, 1));
                        $accountType = ($employee->getIsAdmin() == 1 ? "Administrator" : "Pracownik");
                        $employeeId = $employee->getId();
                        $is_deleted = $employee->getIsDeleted() == 1 ? "deleted" : false;
                        $handleClick = "index.php?section=employees&action=editEmployeeForm&id=".$employeeId;
                        if ($employee->getIsDeleted() == 1 ) {
                            $accountType = "Usunięty";
                        }
                        echo '
                        <div class="col-xxl-2 col-xl-3 col-lg-3 col-sm-4 col-12 user-box">
                            <div class="box d-flex flex-column">
                                <div class="icon '.$is_deleted.'">
                                    <span>'.$icon.'</span>
                                </div>
                                <div class="content">
                                    <p class="username">'.$name.'</p>
                                    <p class="accountType">'.$accountType.'</p>
                                    ';
                                    if ($employee->getIsDeleted() == 0 ) {
                                        echo '
                                        <a class="align-self-end" href='.$handleClick.'><button>Edytuj</button></a>
                                        ';
                                    }
                                    
                                    echo '
                                </div>
                            </div>
                        </div>
                        ';
                    }

                ?>
            </div>
        </div>
    </div>


    <script src="./assets/js/employees.js"></script>

</body>

</html>
