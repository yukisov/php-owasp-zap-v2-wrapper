<?php

namespace Yukisov\ZapWrapper;


class Users {

	/**
	 * @param \Zap\Zapv2 $zap
	 */
	public function __construct(\Zap\Zapv2 $zap)
	{
		$this->zap = $zap;
	}

	/**
	 *
	 *
	 * (1) サーバーから戻り値(JSONの文字列): 正常な場合
	 * {"usersList":[
	 *     { "credentials":{
	 *          "password":"password",
	 *          "type":"UsernamePasswordAuthenticationCredentials",
	 *          "username":"yukisov@gmail.com"},
	 *       "name":"yukisov",
	 *       "contextId":"1",
	 *       "id":"0",
	 *       "enabled":"true"},
	 *     { "credentials":{
	 *           "password":"password",
	 *           "type":"UsernamePasswordAuthenticationCredentials",
	 *           "username":"barsov@gmail.com"},
	 *       "name":"bar",
	 *       "contextId":"1",
	 *       "id":"1",
	 *       "enabled":"true"}
	 * ]}
	 *
	 * この場合、zap->users->usersList($context_id)の戻り値の配列になる
	 *
	 * class stdClass#33 (5) {
	 *   public $credentials =>
	 *     class stdClass#34 (3) {
	 *       public $password => string(8) "password"
	 *       public $type => string(41) "UsernamePasswordAuthenticationCredentials"
	 *       public $username => string(17) "yukisov@gmail.com"
	 *     }
	 *     public $name => string(7) "yukisov"
	 *     public $contextId =>	string(1) "1"
	 *     public $id => string(1) "0"
	 *     public $enabled => string(4) "true"
	 * }
	 *
	 *
	 * サーバーから戻り値(JSONの文字列): ユーザーが0の場合
	 * {"usersList":[]}
	 *
	 * この場合、zap->users->usersList($context_id)の戻り値は以下になる
	 * array()
	 *
	 * @param $context_id
	 * @return array
	 */
	public function usersList($context_id)
	{
		/* ユーザーの登録がなければ array() が返る */
		return $this->zap->users->usersList($context_id);
	}

	/**
	 *
	 *
	 * \Zap\Users::newUser()でサーバーから戻ってくるJSON文字列
	 * 成功時：
	 *     {"Result":"OK"}
	 * エラー時：
	 *     {"code":"context_not_found","message":"No Context found that matches parameter","detail":"contextId"}
	 *
	 * @param $context_id
	 * @param $name
	 * @param $api_key
	 * @throws Exception
	 */
	public function newUser($context_id, $name, $api_key)
	{
		try {
			$resJsonObj = $this->zap->users->newUser($context_id, $name, $api_key);
			$this->zap->expectOk($resJsonObj);
		} catch (\Exception $e) {
			throw new Exception("newUser Failed", Exception\Code::USERS_NEW_USER, $e);
		}
	}

	/**
	 * @param $login_username
	 * @param $login_password
	 * @param $context_id
	 * @param $user_id
	 * @param $api_key
	 * @throws Exception
	 */
	public function setAuthenticationCredentials($login_username, $login_password, $context_id, $user_id, $api_key)
	{
		try {
			/* setAuthenticationCredentials */
			$auth_credentials_config_params = "username=" . $login_username . "&password=" . $login_password;
			$resJsonObj = $this->zap->users->setAuthenticationCredentials(
				$context_id, $user_id, $auth_credentials_config_params, $api_key
			);
			$this->zap->expectOk($resJsonObj);
		} catch (\Zap\ZapError $e) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::USERS_SET_AUTH_CREDENTIALS, $e);
		}
	}

	/**
	 * @param $context_id
	 * @param $user_id
	 * @param $enabled
	 * @param $api_key
	 * @throws Exception
	 */
	public function setUserEnabled($context_id, $user_id, $enabled, $api_key)
	{
		try {
			$resJsonObj = $this->zap->users->setUserEnabled($context_id, $user_id, $enabled, $api_key);
			$this->zap->expectOk($resJsonObj);
		} catch (\Zap\ZapError $e) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::USERS_SET_USER_ENABLED, $e);
		}
	}
}