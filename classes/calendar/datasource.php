<?php

namespace Calendar;

class Calendar_Datasource {
	
	/**
	 * Called by Calendar upon creation
	 */
	public abstract static function init() {}

	/**
	 * @param   DateTime  Start date or day to retrieve events for
	 * @param   DateTime  End date
	 * @return  array     Calendar_Events taking matching above date(s)
	 */
	public abstract static function get_events($date_start, $date_end = null) {}

	/**
	 * @param   Calendar_Event  
	 * @return  boolean         
	 */
	public abstract static function add_event($event) {}

	/**
	 * @param   Calendar_Event  
	 * @return  boolean         
	 */
	public abstract static function delete_event($event) {}

}