<?php
/**
*
* Project SCITCH
*
* Database class.
*
**/

require_once 'config.php';
require_once 'util.php';
require_once 'carbon.php';

class Database{

  // ===================
  // = Private Methods =
  // ===================
  private function dbConnect(){
    if( defined('DB_PORT') && defined('DB_SOCKET') ){
      // For local dev must set port and socket
      $mysqli = mysqli_connect(
        constant('DB_HOST'),
        constant('DB_USER'),
        constant('DB_PASS'),
        constant('DB_DATABASE'),
        constant('DB_PORT'),
        constant('DB_SOCKET'));
      return $mysqli;
    } else {
      // In prod we dont need port or socket
      $mysqli = mysqli_connect(
        constant('DB_HOST'),
        constant('DB_USER'),
        constant('DB_PASS'),
        constant('DB_DATABASE'));
      return $mysqli;
    }
  }

  // ===================
  // = Public Methods =
  // ===================

  /**
    * Load a segment of records with sorting. Used for paged records.
    * @param  integer $offset Record to start at
    * @param  integer $limit  Number of records to return
    * @param  string $sort    ASC or DESC sort direct
    * @param  string $sortby  DB column to sort on.
    * @return array           An array of sorted records.
  */
  public function getRecords($offset = 0, $limit = 50, $sort = 'DESC', $sortby = 'uid', $filter = 'all'){
    $mysqli = $this->dbConnect();
    if( !$mysqli ){return FALSE;}

    $query = "SELECT uid, site, url, referral, sponsorship, adkey1, adkey2, category, unique_id, page_type, detail_id, created_at, modifed_at, timestamp FROM MdScrapper3 ORDER BY ? ASC LIMIT ? OFFSET ?";

      // Handle filtering options
      if( $filter != 'all' ){
        // Split on : for column and value
        $sp = preg_split('/:/', $filter);

        $query = "SELECT uid, site, url, referral, sponsorship, adkey1, adkey2, category, unique_id, page_type, detail_id, created_at, modifed_at, timestamp FROM MdScrapper3 WHERE $sp[0] = '$sp[1]' ORDER BY ? ASC LIMIT ? OFFSET ?";
      }

      // Utility::dd($query);

    try {
      $stmt = $mysqli->prepare($query);

      if($stmt){
        $stmt->bind_param('sii', $sortby, $limit, $offset);

        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($uid, $site, $url, $referral, $sponsorship, $adkey1, $adkey2, $category, $unique_id, $page_type, $detail_id, $created_at, $modifed_at, $timestamp);

        $dataset = array();
        while( $stmt->fetch() ){
          $created_at_for_humans = \Carbon\Carbon::parse($created_at);
          $created_at_for_humans->tz = 'America/New_York';

          if( !is_null($timestamp) ){
            $timestamp_for_humans = \Carbon\Carbon::parse($timestamp);
            $timestamp_for_humans->tz = 'America/New_York';
          } else {
            $timestamp_for_humans = \Carbon\Carbon::parse($created_at);
            $timestamp_for_humans->tz = 'America/New_York';
          }


          $tmp = array(
            "uid" => $uid,
            "site" => $site,
            "url" => $url,
            "referral" => $referral,
            "sponsorship" => $sponsorship,
            "adkey1" => $adkey1,
            "adkey2" => $adkey2,
            "category" => $category,
            "unique_id" => $unique_id,
            "page_type" => $page_type,
            "detail_id" => $detail_id,
            "created_at" => $created_at,
            "created_at_for_humans" => $created_at_for_humans->diffForHumans(),
            "timestamp_for_humans" => $timestamp_for_humans->diffForHumans(),
          );

          array_push($dataset, $tmp);
        }

        $ret = $dataset;
        $stmt->free_result();
        $stmt->close();
        $mysqli->close();
      } else {
        $ret = FALSE;
      }
    } catch (Exception $e) {
      $ret = FALSE;
    }

    return $ret;
  }

  /**
   * Get all data for a record by UID.
   * @param  integer $uid The UID for the record.
   * @return array        An array of the record data.
   */
  public function getDetailByUid($uid){
    $data = array();
    $mysqli = $this->dbConnect();
    if( !$mysqli ){return FALSE;}

    $query = "SELECT uid, site, url, referral, sponsorship, adkey1, adkey2, category, unique_id, page_type, detail_id, created_at, modifed_at, timestamp FROM MdScrapper3 WHERE uid = ?";

    try {
      $stmt = $mysqli->prepare($query);

      if($stmt){
        $stmt->bind_param('i', $uid);

        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($uid, $site, $url, $referral, $sponsorship, $adkey1, $adkey2, $category, $unique_id, $page_type, $detail_id, $created_at, $modifed_at, $timestamp);

        $dataset = array();
        while( $stmt->fetch() ){
          $created_at_for_humans = \Carbon\Carbon::parse($created_at);
          $created_at_for_humans->tz = 'America/New_York';

          if( !is_null($timestamp) ){
            $timestamp_for_humans = \Carbon\Carbon::parse($timestamp);
            $timestamp_for_humans->tz = 'America/New_York';
          } else {
            $timestamp_for_humans = \Carbon\Carbon::parse($created_at);
            $timestamp_for_humans->tz = 'America/New_York';
          }

          return array(
            "uid" => $uid,
            "site" => $site,
            "url" => $url,
            "referral" => $referral,
            "sponsorship" => $sponsorship,
            "adkey1" => $adkey1,
            "adkey2" => $adkey2,
            "category" => $category,
            "unique_id" => $unique_id,
            "page_type" => $page_type,
            "detail_id" => $detail_id,
            "created_at" => $created_at,
            "created_at_for_humans" => $created_at_for_humans->diffForHumans(),
            "timestamp_for_humans" => $timestamp_for_humans->diffForHumans(),
          );
        }
      }
    } catch( Exception $e ){
      return FALSE;
    }
  }

  /**
   * Get all sponsorship codes currently in the system.
   * @return array
   */
  public function getSponsorshipCodes(){
    $mysqli = $this->dbConnect();
    if( !$mysqli ){return FALSE;}
    $data = array();

    $query = "SELECT DISTINCT(sponsorship) FROM MdScrapper3 WHERE sponsorship!='' ORDER BY sponsorship ASC";

    try {
      $stmt = $mysqli->prepare($query);

      if($stmt){
        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($sponsorship);

        $dataset = array();
        while( $stmt->fetch() ){
          array_push($dataset, $sponsorship);
        }

        $ret = $dataset;

        $stmt->free_result();
        $stmt->close();
        $mysqli->close();

      } else {
        $ret = FALSE;
      }
    } catch (Exception $e) {
      $ret = FALSE;
    }
    return $ret;
  }

  public function getSites(){
    $mysqli = $this->dbConnect();
    if( !$mysqli ){return FALSE;}
    $data = array();

    $query = "SELECT DISTINCT(site) FROM MdScrapper3 WHERE sponsorship!='' ORDER BY site ASC";

    try {
      $stmt = $mysqli->prepare($query);

      if($stmt){
        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($site);

        $dataset = array();
        while( $stmt->fetch() ){
          array_push($dataset, $site);
        }

        $ret = $dataset;

        $stmt->free_result();
        $stmt->close();
        $mysqli->close();

      } else {
        $ret = FALSE;
      }
    } catch (Exception $e) {
      $ret = FALSE;
    }
    return $ret;
  }

  public function findByUrl($url){
    $mysqli = $this->dbConnect();
    if( !$mysqli ){return FALSE;}

    $query = "SELECT uid, site, url, referral, sponsorship, adkey1, adkey2, category, unique_id, page_type, detail_id, created_at, modifed_at, timestamp FROM MdScrapper3 WHERE url LIKE ?";

    try {
      $stmt = $mysqli->prepare($query);

      if($stmt){
        $stmt->bind_param('sii', $url);

        $stmt->execute();

        $stmt->store_result();

        $stmt->bind_result($uid, $site, $url, $referral, $sponsorship, $adkey1, $adkey2, $category, $unique_id, $page_type, $detail_id, $created_at, $modifed_at, $timestamp);

        $dataset = array();
        while( $stmt->fetch() ){
          $created_at_for_humans = \Carbon\Carbon::parse($created_at);
          $created_at_for_humans->tz = 'America/New_York';

          if( !is_null($timestamp) ){
            $timestamp_for_humans = \Carbon\Carbon::parse($timestamp);
            $timestamp_for_humans->tz = 'America/New_York';
          } else {
            $timestamp_for_humans = \Carbon\Carbon::parse($created_at);
            $timestamp_for_humans->tz = 'America/New_York';
          }


          $tmp = array(
            "uid" => $uid,
            "site" => $site,
            "url" => $url,
            "referral" => $referral,
            "sponsorship" => $sponsorship,
            "adkey1" => $adkey1,
            "adkey2" => $adkey2,
            "category" => $category,
            "unique_id" => $unique_id,
            "page_type" => $page_type,
            "detail_id" => $detail_id,
            "created_at" => $created_at,
            "created_at_for_humans" => $created_at_for_humans->diffForHumans(),
            "timestamp_for_humans" => $timestamp_for_humans->diffForHumans(),
          );

          array_push($dataset, $tmp);
        }

        $ret = $dataset;
        $stmt->free_result();
        $stmt->close();
        $mysqli->close();
      } else {
        $ret = FALSE;
      }
    } catch (Exception $e) {
      $ret = FALSE;
    }

    return $ret;
  }

} // end Database class