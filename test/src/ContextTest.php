<?php namespace Yukisov\ZapWrapper\Test;

class ContextTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @throws \Yukisov\ZapWrapper\Exception
	 */
	public function testIncludeRegexs()
	{
		$context_name = "foo";

		/* create a mock */
		$contextMock = \Mockery::mock("Zap\\Context");
		$contextMock->shouldReceive('includeRegexs')
			->with($context_name)
			->once()
			->andReturn("[http://www.yahoo.co.jp/, http://www.google.com/]");

		/* create a zap */
		$proxy = "localhost:8090";
		$zap = new \Zap\Zapv2('tcp://' . $proxy);
		$zap->setFieldByName('context', $contextMock);

		/* create a zapWrapper */
		$context = new \Yukisov\ZapWrapper\Context($zap);
		$resArr = $context->includeRegexs($context_name);

		$this->assertSame(array("http://www.yahoo.co.jp/", "http://www.google.com/"), $resArr);
	}

	public function testIncludeInContextSuccess()
	{
		/* parameters */
		$context_name = "foo";
		$regex = "\\Q" . "http://www.yahoo.co.jp/" . "\\E.*";
		$api_key = "xxxxxxxx";

		$retExpected = json_decode('{"Result":"OK"}');

		/* create a mock */
		$contextMock = \Mockery::mock("Zap\\Context");
		$contextMock->shouldReceive('includeInContext')
			->with($context_name, $regex, $api_key)
			->once()
			->andReturn($retExpected);

		/* create a zap */
		$proxy = "localhost:8090";
		$zap = new \Zap\Zapv2('tcp://' . $proxy);
		$zap->setFieldByName('context', $contextMock);

		/* create a zapWrapper */
		$context = new \Yukisov\ZapWrapper\Context($zap);
		$context->includeInContext($context_name, $regex, $api_key);

		$this->assertTrue(true);
	}

	/**
	 * @expectedException \Yukisov\ZapWrapper\Exception
	 */
	public function testIncludeInContextFail()
	{
		/* parameters */
		$context_name = "foo";
		$regex = "\\Q" . "http://www.yahoo.co.jp/" . "\\E.*";
		$api_key = "xxxxxxxx";

		/* invalid returned value */
		$retHappen = json_decode('{"foo":"bar"}');

		/* create a mock */
		$contextMock = \Mockery::mock("Zap\\Context");
		$contextMock->shouldReceive('includeInContext')
			->with($context_name, $regex, $api_key)
			->once()
			->andReturn($retHappen);

		/* create a zap */
		$proxy = "localhost:8090";
		$zap = new \Zap\Zapv2('tcp://' . $proxy);
		$zap->setFieldByName('context', $contextMock);

		/* create a zapWrapper */
		$context = new \Yukisov\ZapWrapper\Context($zap);
		$context->includeInContext($context_name, $regex, $api_key);

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