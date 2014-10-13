<?php namespace Yukisov\ZapWrapper\Test;

class ZapWrapperTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function testInitializeFailed()
	{
		try {
			$zapWrapper = new \Yukisov\ZapWrapper\ZapWrapper();
			$zapWrapper->setZapPort("1");
			$zapWrapper->initialize();
		} catch (\Yukisov\ZapWrapper\Exception $e) {
			$this->assertSame("Yukisov\\ZapWrapper\\ZapWrapper::createZapObj Failed", $e->getMessage());
			return;
		}
		$this->assertTrue(false);
	}

	/**
	 * @test
	 */
	public function testSetForcedUserModeEnabledFail()
	{
		try {
			$zapWrapper = new \Yukisov\ZapWrapper\ZapWrapper();
			$zapWrapper->initialize();
			$zapWrapper->setForcedUserModeEnabled("dummy");
		} catch (\Yukisov\ZapWrapper\Exception $e) {
			$this->assertSame("Yukisov\\ZapWrapper\\ZapWrapper::setForcedUserModeEnabled Failed", $e->getMessage());
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