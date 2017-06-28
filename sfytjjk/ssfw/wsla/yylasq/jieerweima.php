<?php 

include('../../../common/global.php');

$password = _request('pwd'); 

if($password){
    $password = think_decrypt($password);
}else{
    $password = '';
}

echo json_encode($password);


?>