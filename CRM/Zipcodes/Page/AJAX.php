<?php

/* 
 * Autocomplete for postcodes
 * 
 */

class CRM_Zipcodes_Page_AJAX {
/*  
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
 */  

  function autocomplete() {
    $str = CRM_Utils_Request::retrieve('term', 'String', CRM_Core_DAO::$_nullObject, TRUE, '');
    if (empty($str)) {
      CRM_Utils_System::civiExit();
    }
    $a_json = array();
    $a_json_row = array();
    if (!empty($str)) {
      //$location_qry_str = "SELECT zip, city, state, country FROM civicrm_zipcodes WHERE (`city` LIKE %1 OR `zip` LIKE %2) ORDER BY `city` ASC";
      $location_qry_str = "
SELECT zip, city, country, civicrm_country.id AS country_id, civicrm_state_province.id AS state_id FROM civicrm_zipcodes
LEFT JOIN civicrm_country ON civicrm_zipcodes.country = civicrm_country.iso_code
LEFT JOIN civicrm_state_province ON civicrm_state_province.country_id = civicrm_country.id AND civicrm_state_province.abbreviation = civicrm_zipcodes.state
WHERE (`city` LIKE %1 OR `zip` LIKE %2) ORDER BY `city` ASC";
CRM_Core_Error::debug_log_message($location_qry_str);
      $dao = CRM_Core_DAO::executeQuery($location_qry_str, array(
        '1' => array($str.'%', 'String'),
        '2' => array($str.'%', 'String'),
      ));
      while ($dao->fetch()) {
        //echo $dao->zip . " - ".$dao->city ."|".$dao->zip . ' - '.$dao->city."\n";
        $a_json_row['id'] = $dao->zip . '|' . $dao->city . '|' . $dao->country_id . '|' . $dao->state_id;
        //$a_json_row['value'] = $dao->zip . '|' . $dao->city . '|' . $dao->country_id . '|' . $dao->state_id;
        $a_json_row['value'] = $dao->zip . ' | ' . $dao->city;
        $a_json_row['label'] = $dao->zip . ' | ' . $dao->city;
        array_push($a_json, $a_json_row);
      }
      $json = json_encode($a_json);
      print $json;
    }
    CRM_Utils_System::civiExit();
  }

}
