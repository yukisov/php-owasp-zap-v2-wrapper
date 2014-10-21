<?php
namespace Yukisov\ZapWrapper\Test;

class UsersTest extends \PHPUnit_Framework_TestCase {

  /**
   *
   * usersList()は \Zap\Users::usersList()をそのまま返しているのでテストの必要はない。
   * @throws \Yukisov\ZapWrapper\Exception
   */
  /*public function testUsersList()
  {
  }*/

  /**
   * 実質テストする価値のある処理がない。
   */
  public function testNewUserFail()
  {
    $this->assertTrue(true);
  }

  /**
   *
   */
  public function tearDown()
  {
    \Mockery::close();
  }
}
