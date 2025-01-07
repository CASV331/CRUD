<?php
if ($_SESSION['id'] != 1) {
    header('Location:' . APP_URL . 'dashboard/');
}
