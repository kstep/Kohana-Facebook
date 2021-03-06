<?php
/**
* Kohana-Facebook
*
* @package        Kohana_Facebook
* @author         Jeremy Bush
* @copyright      (c) 2010 Jeremy Bush
* @license        http://www.opensource.org/licenses/isc-license.txt
*/
class Kohana_Facebook
{
	protected static $_instance;

	protected $_facebook;

	protected $_me;

	protected function __construct()
	{
		include Kohana::find_file('vendor', 'facebook/src/facebook');

		// Do class setup
		$config = Kohana::$config->load('facebook');

		$this->_facebook = new Facebook(
			array(
				'appId'  => $config->app_id,
				'secret' => $config->secret,
				'cookie' => true, // enable optional cookie support
			)
		);

		try
		{
			$this->_me = $this->_facebook->api('/me');
		}
		catch (FacebookApiException $e)
		{
			// Do nothing.
		}
	}

	public static function instance()
	{
		if ( ! isset(self::$_instance))
			Kohana_Facebook::$_instance = new Kohana_Facebook;

		return Kohana_Facebook::$_instance;
	}

	public function app_id()
	{
		return $this->_facebook->getAppId();
	}

	public function logged_in()
	{
		return $this->_me != NULL;
	}

	public function user_id()
	{
		return $this->_facebook->getUser();
	}

	public function account()
	{
		return $this->_me;
	}

	public function facebook()
	{
		return $this->_facebook;
	}
}
