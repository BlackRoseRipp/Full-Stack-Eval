<?php
    include('../Controllers/Controller.php');
    $inputs = new Controller();
    $inputs->setKeyword("calculus");

    $log = array();
    $log["insert_log"] = NULL;


    if($inputs->validate($_POST["choices"])){
        $log["insert_log"] = $inputs->post();
    }


    $log["message"] = $inputs->getMessage();

    echo json_encode($log);
?>
