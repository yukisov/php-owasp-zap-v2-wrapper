<?php namespace Yukisov\ZapWrapper;

/**
 * Class ZapWrapper
 *
 * \Zap\Zapv2 クラスはそのままでは使い難いのでそのクラスでラップする。
 *
 * @package Yukisov\Zap
 */
class ZapWrapper {

	private $zap = null;
	private $zap_host = "localhost";
	/** @var string */
	private $zap_port = "8090";
	private $target_url = "http://localhost:8000/";
	/** @var string */
	private $login_url = "";
	/** @var string */
	private $login_post_data = "";
	/** @var string */
	protected $zap_api_key = "";

	private $login_username = "";
	private $login_password = "";

	private $alerts = null;

	/**
	 *
	 */
	public function initialize()
	{
		$proxy = $this->zap_host . ':' . $this->zap_port;
		$this->zap = $this->createZapObj($proxy);
	}

	/**
	 * @param $proxy
	 * @throws Exception
	 * @return \Zap\Zapv2
	 */
	private function createZapObj($proxy)
	{
		$zap = new \Zap\Zapv2('tcp://' . $proxy);

		$version = @$zap->core->version();
		if (is_null($version)) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::CREATE_ZAP_OBJECT);
			return;
		}
		return $zap;
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

	/**
	 * forcedUser の設定
	 * @param $boolean
	 * @throws Exception
	 * @internal param $zap
	 * @internal param $boolean
	 */
	public function setForcedUserModeEnabled($boolean)
	{
		$str_boolean = ($boolean) ? 'true' : 'false';
		try {
			$resJsonObj = $this->zap->forcedUser->setForcedUserModeEnabled($str_boolean, $this->zap_api_key);
			$this->zap->expectOk($resJsonObj);
		} catch (\Zap\ZapError $e) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::FORCED_USER_ENABLED, $e);
		}
	}

	/**
	 *
	 * この内部で使用するAPIは、どんな値を投げてもそれが原因でエラーを返すことはない。
	 *
	 * @param $token_name
	 * @param bool $force  true: add if the same token already exists.
	 * @throws Exception
	 */
	public function addAntiCsrfToken($token_name, $force=false)
	{
		$acsrf = new Acsrf($this->zap);

		if (! $force) {
			/* 一覧を取得する */
			$arr_tokens = $acsrf->optionTokensNames();

			/* その中に見付からなかったら終了する */
			if (in_array($token_name, $arr_tokens)) {
				return;
			}
		}

		/* トークンを追加する */
		$acsrf->addOptionToken($token_name, $this->zap_api_key);
	}

	/**
	 *
	 * この内部で使用するAPIは、どんな値を投げてもそれが原因でエラーを返すことはない。
	 *
	 * @param $token_name
	 * @throws Exception
	 */
	public function removeAntiCsrfToken($token_name)
	{
		$acsrf = new Acsrf($this->zap);
		$acsrf->removeOptionToken($token_name, $this->zap_api_key);
	}

	/**
	 * @param $context_name
	 * @param $regex
	 * @throws Exception
	 * @internal param $zap_api_key
	 * @internal param $context_id
	 */
	public function includeInContext($context_name, $regex)
	{
		$context = new Context($this->zap);

		/* 現在の値を取得する */
		$arr_regex = $context->includeRegexs($context_name);

		if (! in_array($regex, $arr_regex)) {
			return;
		}

		/* その中に無ければ追加する */
		$context->includeInContext($context_name, $regex, $this->zap_api_key);
	}

	/**
	 * @param $context_id
	 * @param $name
	 * @throws Exception
	 */
	public function newUser($context_id, $name)
	{
		$users = new Users($this->zap);
		$users->newUser($context_id, $name, $this->zap_api_key);
	}
} 