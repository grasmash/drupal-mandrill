<?php
namespace Drupal\mandrill;

use Mandrill;
use Mandrill_Templates;
Use Mandrill_Exports;
use Mandrill_Users;
use Mandrill_Rejects;
use Mandrill_Inbound;
use Mandrill_Tags;
use Mandrill_Messages;
use Mandrill_Whitelists;
use Mandrill_Ips;
use Mandrill_Internal;
use Mandrill_Subaccounts;
use Mandrill_Urls;
use Mandrill_Webhooks;
use Mandrill_Senders;
use Mandrill_Metadata;
use Mandrill_Error;
use Mandrill_HttpError;

/**
 * Class DrupalMandrill.
 */
class DrupalMandrill extends Mandrill {

  protected $userAgent;
  protected $timeout;

  /**
   * Override constructor to remove curl operations.
   */
  public function __construct($apikey = NULL, $timeout = 60) {
    if (!$apikey) {
      throw new Mandrill_Error('You must provide a Mandrill API key');
    }
    $this->apikey = $apikey;

    $library = libraries_load('mandrill');
    $this->userAgent = "Mandrill-PHP/{$library['version']}";
    $this->timeout = $timeout;

    $this->root = rtrim($this->root, '/') . '/';

    $this->templates = new Mandrill_Templates($this);
    $this->exports = new Mandrill_Exports($this);
    $this->users = new Mandrill_Users($this);
    $this->rejects = new Mandrill_Rejects($this);
    $this->inbound = new Mandrill_Inbound($this);
    $this->tags = new Mandrill_Tags($this);
    $this->messages = new Mandrill_Messages($this);
    $this->whitelists = new Mandrill_Whitelists($this);
    $this->ips = new Mandrill_Ips($this);
    $this->internal = new Mandrill_Internal($this);
    $this->subaccounts = new Mandrill_Subaccounts($this);
    $this->urls = new Mandrill_Urls($this);
    $this->webhooks = new Mandrill_Webhooks($this);
    $this->senders = new Mandrill_Senders($this);
    $this->metadata = new Mandrill_Metadata($this);
  }

  /**
   * Override _destruct() to prevent calling curl_close().
   */
  public function __destruct() {}

  /**
   * Override call method to user Drupal's HTTP handling.
   */
  public function call($url, $params) {
    $params['key'] = $this->apikey;
    $params = \Drupal\Component\Serialization\Json::encode($params);

    // @FIXME
// drupal_http_request() has been replaced by the Guzzle HTTP client, which is bundled
// with Drupal core.
// 
// 
// @see https://www.drupal.org/node/1862446
// @see http://docs.guzzlephp.org/en/latest
// $response = drupal_http_request(
//       $this->root . $url . '.json',
//       array(
//         'method' => 'POST',
//         'data' => $params,
//         'headers' => array(
//           'Content-Type' => 'application/json',
//           'Accept-Language' => language_default()->language,
//           'User-Agent' => $this->userAgent,
//         ),
//         'timeout' => $this->timeout,
//       )
//     );


    if (!empty($response->error)) {
      throw new Mandrill_HttpError(t('Mandrill API call to !url failed: @msg', array('!url' => $url, '@msg' => $response->error)));
    }

    $result = \Drupal\Component\Serialization\Json::decode($response->data);

    if ($result === NULL) {
      throw new Mandrill_Error('We were unable to decode the JSON response from the Mandrill API: ' . $response->data);
    }

    if (floor($response->code / 100) >= 4) {
      throw $this->castError($result);
    }

    return $result;
  }

}