<?php
namespace Yukisov\ZapWrapper\Test;

class ZapWrapperTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function initializeFailed()
  {
    try {
      $zapWrapper = new \Yukisov\ZapWrapper\ZapWrapper();
      /* This port number must not exist!! */
      $zapWrapper->setZapPort("1");
      $zapWrapper->initialize();
    } catch (\Yukisov\ZapWrapper\Exception $e) {
      $this->assertSame(
        "Yukisov\\ZapWrapper\\ZapWrapperBase::initialize Failed",
        $e->getMessage());
      return;
    }
    $this->assertTrue(false);
  }

  /**
   * @test
   */
  public function setForcedUserModeEnabledFail()
  {
    $api_key = 'xxxxxxxx';
    try {
      $zapWrapper = new \Yukisov\ZapWrapper\ZapWrapper();
      $zapWrapper->initialize();
      $zapWrapper->forcedUser->setForcedUserModeEnabled(true, $api_key);
    } catch (\Yukisov\ZapWrapper\Exception $e) {
      $this->assertSame(
        "Yukisov\\ZapWrapper\\ForcedUser::setForcedUserModeEnabled Failed",
        $e->getMessage());
      return;
    }
    $this->assertTrue(false);
  }

  /**
   *
   */
  public function tearDown()
  {
    \Mockery::close();
  }
}
