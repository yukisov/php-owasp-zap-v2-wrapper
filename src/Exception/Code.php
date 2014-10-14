<?php namespace Yukisov\ZapWrapper\Exception;

class Code {
	const CREATE_ZAP_OBJECT            = 1;
	const FORCED_USER_ENABLED          = 2;
	const FORCED_USER_SET              = 3;
	const FORCED_USER_SET_MODE_ENABLED = 4;
	const ADD_ACSRF_TOKEN              = 4;
	const REMOVE_ACSRF_TOKEN           = 5;
	const CONTEXT_INCLUDE_REGEXS       = 6;
	const CONTEXT_INCLUDE_IN_CONTEXT   = 7;
	const USERS_NEW_USER               = 8;
	const USERS_SET_AUTH_CREDENTIALS   = 9;
	const USERS_SET_USER_ENABLED       = 10;
}