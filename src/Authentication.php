<?php
namespace Yukisov\ZapWrapper;

class Authentication {

  /**
   * @param \Zap\Zapv2 $zap
   */
  public function __construct(\Zap\Zapv2 $zap)
  {
    $this->zap = $zap;
  }

  /**
   * @param $context_id
   * @param $auth_method_name
   * @param string $auth_method_config_params
   * @param string $api_key
   * @throws Exception
   */
  public function setAuthenticationMethod($context_id, $auth_method_name, $auth_method_config_params='', $api_key='')
  {
    try {
      /* クレデンシャルを登録 */
      $resJsonObj = $this->zap->authentication->setAuthenticationMethod(
        $context_id, $auth_method_name, $auth_method_config_params, $api_key);
      $this->zap->expectOk($resJsonObj);
    } catch (\Exception $e) {
      throw new Exception(__METHOD__ . " Failed", Exception\Code::AUTH_SET_AUTH_METHOD, $e);
    }
  }

  /**
   * @param $context_id
   * @param $logged_in_indicator_regex
   * @param string $api_key
   * @throws Exception
   */
  public function setLoggedInIndicator($context_id, $logged_in_indicator_regex, $api_key='')
  {
    try {
      /* LoggedInIndicator を登録する */
      $resJsonObj = $this->zap->authentication->setLoggedInIndicator(
        $context_id, $logged_in_indicator_regex, $api_key);
      $this->zap->expectOk($resJsonObj);
    } catch (\Exception $e) {
      throw new Exception(__METHOD__ . " Failed", Exception\Code::AUTH_SET_LOGGED_IN_INDICATOR, $e);
    }
  }
}
