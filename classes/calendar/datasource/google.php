<?php

namespace Calendar;

class Calendar_Datasource_Google extends Calendar_Datasource {

	protected $access_token;
	protected $access_expires;

	public static function init($options)
	{
		// s
	}
	
	/**
	 * @param   DateTime  Start date or day to retrieve events for
	 * @param   DateTime  End date
	 * @return  array     Calendar_Events taking matching above date(s)
	 */
	public static function get_events($date_start, $date_end = null) {
		
	}

	/**
	 * @param   Calendar_Event  
	 * @return  boolean         
	 */
	public abstract function add_event($event) {}

	/**
	 * @param   Calendar_Event  
	 * @return  boolean         
	 */
	public abstract function delete_event($event) {}

	protected function refresh_token($refresh_token)
	{
		// Send a curl request for an access token, given a refresh token
		$config = \Config::get('calendar.google');
		curl($config['token_endpoint'], array(
			'client_id' => $config['client_id'],
			'client_secret' => $config['client_secret'],
		));
		// Assume the response is in $response;
		$response = json_decode($response);
		$this->access_token = $response->access_token;
		$this->access_expires = DateTime::createFromFormat(time() + $response->expires_in, 'U');
	}

}