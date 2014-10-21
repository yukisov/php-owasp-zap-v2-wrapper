<?php
namespace Yukisov\ZapWrapper;

class Context {

  /**
   * @param \Zap\Zapv2 $zap
   */
  public function __construct(\Zap\Zapv2 $zap)
  {
    $this->zap = $zap;
  }

  /**
   * List included regexs for context
   *
   * - APIの引数名の通り、コンテキスト名(IDではない)で取得する。
   *
   * includeRegexs API の戻り値
   * - 値があった場合に戻ってくるJSON
   *   {"includeRegexs":"[http://www.yahoo.co.jp/, http://www.google.com/]"}
   * - 値がない場合に戻ってくるJSON
   *   {"code":"does_not_exist","message":"Does Not Exist","detail":"foo"}
   *
   * @param $context_name
   * @return array
   */
  public function includeRegexs($context_name)
  {
    /* 値がなければ null */
    $resStr = @$this->zap->context->includeRegexs($context_name);
    if (is_null($resStr) || (is_array($resStr) && count($resStr) == 0)) {
      return array();
    }

    /* 登録されたURL正規表現を配列に変換する */
    // この時点で $resStrは、以下の様な文字列になっている。
    // "[http://www.yahoo.co.jp/, http://www.google.com/]"
    $s = trim($resStr, '[] ');
    $retArr = preg_split('/, */', $s);
    $retArr = array_map(function($s){return trim($s);}, $retArr);

    return $retArr;
  }

  /**
   * Add include regex to context
   *
   * @param $context_name
   * @param $regex
   * @param $api_key
   * @throws Exception
   */
  public function includeInContext($context_name, $regex, $api_key)
  {
    /* 現在の値を取得する */
    $arr_regex = $this->includeRegexs($context_name);
    if (in_array($regex, $arr_regex)) {
      return;
    }

    try {
      $resJsonObj = $this->zap->context->includeInContext($context_name, $regex, $api_key);
      $this->zap->expectOk($resJsonObj);
    } catch (\Exception $e) {
      throw new Exception("includeInContext Failed", Exception\Code::CONTEXT_INCLUDE_IN_CONTEXT, $e);
    }
  }
}
