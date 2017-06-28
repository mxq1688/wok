<?php
      include('../common/global.php');
      $result = array();

      $sql = "select * from ssfw_sdhz_type ";
      $list = $mysql -> get_all($sql);
      $result['state'] = 1;  
      $result['data'] = $list;  
      echo json_encode($result);
?>
