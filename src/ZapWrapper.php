<?php
namespace Yukisov\ZapWrapper;

/**
 * Class ZapWrapper
 *
 * \Zap\Zapv2 クラスはそのままでは使い難いのでそのクラスでラップする。
 *
 * @package Yukisov\Zap
 */
class ZapWrapper extends ZapWrapperBase {

  public $acsrf = null;
  public $authentication = null;
  public $context = null;
  public $forcedUser = null;
  public $users = null;

  public function initialize()
  {
    parent::initialize();

    $this->acsrf = new Acsrf($this->zap);
    $this->authentication = new Authentication($this->zap);
    $this->context = new Context($this->zap);
    $this->forcedUser = new ForcedUser($this->zap);
    $this->users = new Users($this->zap);
  }
}
