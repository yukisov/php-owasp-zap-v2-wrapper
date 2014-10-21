<?php
namespace Yukisov\ZapWrapper\Test;

class AcsrfTest extends \PHPUnit_Framework_TestCase {

  /**
   *
   */
  public function testOptionTokensNames()
  {
    /* create a mock */
    $acsrfMock = \Mockery::mock("Zap\\Context");
    $acsrfMock->shouldReceive('optionTokensNames')
      ->once()
      ->andReturn("[anticsrf, CSRFToken, __RequestVerificationToken, csrfmiddlewaretoken]");

    /* create a zap */
    $proxy = "localhost:8090";
    $zap = new \Zap\Zapv2('tcp://' . $proxy);
    $zap->setFieldByName('acsrf', $acsrfMock);

    /* create a zapWrapper */
    $acsrf = new \Yukisov\ZapWrapper\Acsrf($zap);
    $resArr = $acsrf->optionTokensNames();

    $this->assertSame(
      array("anticsrf", "CSRFToken", "__RequestVerificationToken", "csrfmiddlewaretoken"),
      $resArr
    );
  }

  /**
   */
  /*public function testNewUserFail()
  {
  }*/

  /**
   *
   */
  public function tearDown()
  {
    \Mockery::close();
  }
}
