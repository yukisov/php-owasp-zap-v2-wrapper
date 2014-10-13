<?php namespace Yukisov\ZapWrapper;


class Exception extends \Exception {

	const CODE_FORCED_USER_ENABLED = 1;

	public function __construct($message, $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}