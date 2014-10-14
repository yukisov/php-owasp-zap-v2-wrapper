<?php

namespace Yukisov\ZapWrapper;


class Acsrf {

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
	 * サーバーから戻り値(JSONの文字列):
	 * {"TokensNames":"[anticsrf, CSRFToken, __RequestVerificationToken, csrfmiddlewaretoken]"}
	 * トークンが0の場合:
	 * {"TokensNames":"[]"}
	 *
	 * 通常、エラーにはならない。
	 *
	 * @internal param $context_id
	 * @return array
	 */
	public function optionTokensNames()
	{
		/* ユーザーの登録がなければ array() が返る */
		$resStr = $this->zap->acsrf->optionTokensNames();

		/* 登録されたトークンを配列に変換する */
		// この時点で $resStrは、以下の様な文字列になっている。
		// "[anticsrf, CSRFToken, __RequestVerificationToken, csrfmiddlewaretoken]"
		$s = trim($resStr, '[] ');
		$retArr = preg_split('/, */', $s);
		$retArr = array_map(function($s){return trim($s);}, $retArr);

		return $retArr;
	}

	/**
	 * @param $token_name
	 * @param $api_key
	 * @throws Exception
	 */
	public function addOptionToken($token_name, $api_key)
	{
		try {
			$resJsonObj = $this->zap->acsrf->addOptionToken($token_name, $api_key);
			$this->zap->expectOk($resJsonObj);
		} catch (\Zap\ZapError $e) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::ADD_ACSRF_TOKEN, $e);
		}
	}

	/**
	 * @param $token_name
	 * @param $api_key
	 * @throws Exception
	 */
	public function removeOptionToken($token_name, $api_key)
	{
		try {
			$resJsonObj = $this->zap->acsrf->removeOptionToken($token_name, $api_key);
			$this->zap->expectOk($resJsonObj);
		} catch (\Zap\ZapError $e) {
			throw new Exception(__METHOD__ . " Failed", Exception\Code::REMOVE_ACSRF_TOKEN, $e);
		}
	}
}