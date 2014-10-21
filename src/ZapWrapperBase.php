<?php
namespace Yukisov\ZapWrapper;

class ZapWrapperBase {

  protected $zap = null;
  protected $zap_host = "localhost";
  /** @var string */
  protected $zap_port = "8090";
  protected $target_url = "http://localhost:8000/";
  /** @var string */
  protected $login_url = "";
  /** @var string */
  protected $login_post_data = "";
  /** @var string */
  protected $zap_api_key = "";

  protected $login_username = "";
  protected $login_password = "";

  protected $alerts = null;

  /**
   *
   */
  public function initialize()
  {
    $proxy = $this->zap_host . ':' . $this->zap_port;

    $zap = new \Zap\Zapv2('tcp://' . $proxy);
    $version = @$zap->core->version();
    if (is_null($version)) {
      throw new Exception(__METHOD__ . " Failed", Exception\Code::CREATE_ZAP_OBJECT);
    }
    $this->zap = $zap;
  }

  /**
   * @param $zap_api_key
   * @return $this
   */
  public function setZapApiKey($zap_api_key)
  {
    $this->zap_api_key = $zap_api_key;
    return $this;
  }

  /**
   * @param $host
   * @return $this
   */
  public function setZapHost($host)
  {
    $this->zap_host = $host;
    return $this;
  }

  /**
   * @param $port
   * @return $this
   */
  public function setZapPort($port)
  {
    $this->zap_port = $port;
    return $this;
  }

  /**
   * @param $url
   * @return $this
   */
  public function setTargetUrl($url)
  {
    $this->target_url = $url;
    return $this;
  }

  /**
   * @param $url
   * @return $this
   */
  public function setLoginUrl($url)
  {
    $this->login_url = $url;
    return $this;
  }

  /**
   *
   * - key1=value1&key2=value2 の形式の文字列を URL Encode した文字列が渡される。
   * - CSRF対策トークンも値はダミーでいいので含める。
   * - ユーザ名に当たるパラメータ値は {%username%} と書いておく。
   * - パスワードに当たるパラメータ値は {%password%} と書いておく。
   *
   * @param string $post_data
   * @return $this
   */
  public function setLoginPostData($post_data)
  {
    $this->login_post_data = $post_data;
    return $this;
  }

  /**
   * @param $username
   * @return $this
   */
  public function setLoginUsername($username)
  {
    $this->login_username = $username;
    return $this;
  }

  /**
   * @param $password
   * @return $this
   */
  public function setLoginPassword($password)
  {
    $this->login_password = $password;
    return $this;
  }

  /**
   * @return null
   */
  public function getAlerts()
  {
    return $this->alerts;
  }
}
