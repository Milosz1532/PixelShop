<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
    <!---------------------- NAVIGATION ------------------------->
    <nav>
        <ul>
            <li>
                <a>
                    <span class="material-icons">bolt</span>
                    <span class="title">Pixel</span>
                </a>
            </li>
            <li>
                <a href="index.php">
                    <span class="material-icons">home</span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="index.php?section=products">
                    <span class="material-icons">category</span>
                    <span class="title">Produkty</span>
                </a>
            </li>
            <li>
                <a href="index.php?section=orders">
                    <span class="material-icons">pending_actions</span>
                    <span class="title">Zamówienia</span>
                </a>
            </li>
            <li>
                <a href="index.php?section=customers">
                    <span class="material-icons">assignment_ind</span>
                    <span class="title">Klienci</span>
                </a>
            </li>
            <?php
                if($_SESSION['userData']['accountType'] == 1) {
                    echo '
                    <li>
                        <a href="index.php?section=employees">
                            <span class="material-icons">diversity_3</span>
                            <span class="title">Pracownicy</span>
                        </a>
                    </li>
                    ';
                }
            ?>
            <li>
                <a href="index.php?section=login&action=logout">
                    <span class="material-icons">logout</span>
                    <span class="title">Wyloguj się</span>
                </a>
            </li>
        </ul>
    </nav>
    <!----------------------END NAVIGATION ------------------------->
</body>
</html>