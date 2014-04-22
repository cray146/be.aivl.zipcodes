<?php

/* 
 * Autocomplete for postcodes
 * 
 */

class CRM_Zipcodes_Page_AJAX {
  
  function autocomplete() {
    
    $str = CRM_Utils_Request::retrieve('s', 'String', CRM_Core_DAO::$_nullObject, TRUE, '');
    if (empty($str)) {
      CRM_Utils_System::civiExit();
    }
    
    if (!empty($str)) {
      $location_qry_str = "SELECT zip, city FROM civicrm_zipcodes WHERE (`city` LIKE %1 OR `zip` LIKE %2) ORDER BY `city` ASC";
      $dao = CRM_Core_DAO::executeQuery($location_qry_str, array(
        '1' => array($str.'%', 'String'),
        '2' => array($str.'%', 'String'),
      ));
      while ($dao->fetch()) {
        echo $dao->zip . " - ".$dao->city ."|".$dao->zip . ' - '.$dao->city."\n";
      }
    }
    CRM_Utils_System::civiExit();
  }
  
}
