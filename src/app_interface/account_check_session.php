<?php


require_once "../lib/account/session_login.php";
require_once "../lib/message/enum_state.php";

$status = new appstruct_status();
$status->state = APIState::Error_Unknown;
$status->msg = "";

if(isset($_GET['session'])){
    session_start($_GET['session']);
    if(ss_account_isLoggedIn() == LoginState::OK){
        $status->state = APIState::OK;
    }else{
        $status->state = APIState::Error_LoginRequired;
    }
}else{
    $status->state = APIState::Error_InvalidData;
}

echo json_encode($status);

