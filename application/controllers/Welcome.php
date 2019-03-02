<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once __DIR__ . '/../../vendor/autoload.php';

class Welcome extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('facebook');
  }

  public function index()
  {
    if (!session_id()) session_start();
    $helper = $this->facebook->getFB()->getRedirectLoginHelper();
    $perms = array('email');
    $loginUrl = $helper->getLoginUrl(
      'http://localhost/afterschool/index.php/welcome/callback',
      $perms
    );

    $data_header['actions'] = array(
      'Log In' => '#'
    );

    $data_content['loginUrl'] = $loginUrl;

    $this->load->view('templates/header', $data_header);
    $this->load->view('login', $data_content);
    $this->load->view('templates/footer');
  }

  public function callback()
  {
    if (!session_id()) session_start();

    $fb = $this->facebook->getFB();
    $helper = $fb->getRedirectLoginHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (!isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1	.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }

    // Logged in
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());

    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $fb->getOAuth2Client();

    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);

    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId($this->facebook->getAppId()); // Replace {app-id} with your app id
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();

    if (!$accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
      }

      echo '<h3>Long-lived</h3>';
      var_dump($accessToken->getValue());
    }
  }
}
