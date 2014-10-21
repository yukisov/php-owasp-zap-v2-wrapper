<?php
namespace Yukisov\ZapWrapper;

class ForcedUser {

  /**
   * @param \Zap\Zapv2 $zap
   */
  public function __construct(\Zap\Zapv2 $zap)
  {
    $this->zap = $zap;
  }

  /**
   * @param $context_id
   * @param $user_id
   * @param $api_key
   * @throws Exception
   */
  public function setForcedUser($context_id, $user_id, $api_key)
  {
    try {
      $resJsonObj = $this->zap->forcedUser->setForcedUser($context_id, $user_id, $api_key);
      $this->zap->expectOk($resJsonObj);
    } catch (\Zap\ZapError $e) {
      throw new Exception(__METHOD__ . " Failed", Exception\Code::FORCED_USER_SET, $e);
    }
  }

  /**
   * @param $boolean
   * @param $api_key
   * @throws Exception
   */
  public function setForcedUserModeEnabled($boolean, $api_key)
  {
    $str_boolean = ($boolean) ? 'true' : 'false';

    try {
      $resJsonObj = $this->zap->forcedUser->setForcedUserModeEnabled($str_boolean, $api_key);
      $this->zap->expectOk($resJsonObj);
    } catch (\Zap\ZapError $e) {
      throw new Exception(__METHOD__ . " Failed", Exception\Code::FORCED_USER_SET_MODE_ENABLED, $e);
    }
  }
}
