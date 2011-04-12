
##Planned Features
* <strike>Generate markup for given month</strike>
* Generate a "week" for a given date
* Easy templating using your own Views
* Support for listing events
* Integration with Google Calendar
* Use driver-like datasources to allow custom event storage/retrieval

If you have feature requests, please add them as issues.

##Installation
Add `calendar` to the packages array in app/config/config.php.

##Usage
###Month View
	public function action_month($year = null, $month = null)
	{
		$calendar = \Calendar::factory((int) $year, (int) $month)->generate_month();
		\Calendar::$nav_uri = 'appointments/month';
		$this->template->content = $calendar;
	}