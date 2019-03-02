<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facebook extends CI_Model
{
  const APP_ID = '793867637641127';
  const APP_SECRET = '6e3b23586383677781bc5565f1974949';

  private $fb;
  public function __construct()
  {
    $this->fb = new Facebook\Facebook(array(
      'app_id' => self::APP_ID,
      'app_secret' => self::APP_SECRET,
      'default_graph_version' => 'v2.2',
      'persistent_data_handler' => 'session'
    ));
  }

  public function getFB()
  {
    return $this->fb;
  }

  public function getAppId()
  {
    return self::APP_ID;
  }
}
