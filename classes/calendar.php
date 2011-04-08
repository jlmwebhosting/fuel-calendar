<?php

namespace Calendar;

/**
 * Calendar class.
 *
 * @package Calendar
 */
class Calendar {
	
	public static $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	public static $weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	public static $nav_uri = '';
	protected static $_date;
	protected $_events = array();
	// TODO: protected $_force_show_next_month (and prev?)
	
	
	public static function factory($date = null)
	{
		return new Calendar($date);
	}

	public function __construct($options = null)
	{
		// Set options
		if (is_array($options)) foreach($options_date_string_year as $key => $value)
		{
			$this->{$key} = $value;
		}
		
		static::$_date = $this->parse_date(func_get_args());
		
		return $this;
	}
	
	public function __set($property, $value)
	{
		$this->$property($value);
	}
	
	public function __get($property)
	{
		return $this->$property();
	}
	
	/**
	 * Returns a View for the currently set month
	 *
	 */
	public function generate_month($view = null)
	{
		// Assemble the month into rows of Days
		$date_info = getdate(static::$_date->format('U'));
		$num_days = cal_days_in_month(CAL_GREGORIAN, $date_info['mon'], $date_info['year']);
		$first_day = getdate(mktime(0,0,0, $date_info['mon'], $date_info['mday'], $date_info['year']));
		$days_offset_start = array_search($first_day['weekday'], static::$weekdays);
		$num_rows = ceil(($num_days + $days_offset_start) / 7);
		$days_offset_end = $num_rows * 7 - $num_days - $days_offset_start;
		$current_day = 1 - $days_offset_start;
		$rows = array();
		for ($i=0; $i < $num_rows; $i++)
		{
			$rows[] = array();
			for ($d=0; $d < 7; $d++)
			{
				$rows[$i][$d] = false;
				if ($current_day > 0 and $current_day <= $num_days)
				{
					$date = new \DateTime;
					$date->setDate($date_info['year'], $date_info['mon'], $current_day);
					$rows[$i][$d] = new Calendar_Day($date, array('events' => $this->get_events($date)));
				}
				$current_day++;
			}
		}
		// Create View
		$view = $view ? $view : \Config::get('calendar.template_month', 'month_template');
		$view = \View::factory($view, array('day_rows' => $rows, 'month' => $date_info['month'], 'year' => $date_info['year']));
		
		return $view;
	}
	
	public function date_set($year, $month = null, $day = null)
	{
		! static::$_date and static::$_date = new \DateTime;
		static::$_date->setDate($year, is_null($month) ? 1 : $month, is_null($day) ? 1 : $day);
		return $this;
	}
	
	public function date($date = null)
	{
		if ($date) 
		{
			static::$_date = $date;
			return $this;
		}
		return static::$_date;
	}
	
	public function week_start($weekday = null)
	{
		if ($weekday)
		{
			while (static::$weekdays[0] != ucfirst(strtolower($weekday)))
			{
				static::$weekdays[] = array_shift(static::$weekdays);
			}
			return $this;
		}
		return static::$weekdays[0];
	}
	
	public function add_event($date, $event)
	{
		// Make sure the event is an Event
		! is_a($date, 'Calendar_Event') and $event = Calendar_Event::factory($event);
		
		// Get more detailed info on the date
		$date = is_string($date) ? $date = getdate(strtotime($date)) : getdate($date->format('U'));
		$this->events[$date['year']][$date['mon']][$date['mday']][] = $event;
		return $this;
	}
	
	public function get_events($date)
	{
		$date = is_string($date) ? $date = getdate(strtotime($date)) : getdate($date->format('U'));
		$events = @$this->_events[$date['year']][$date['mon']][$date['mday']];
		return $events ? $events : array();
	}
	
	public static function prev_month_link($text = '<<')
	{
		$prev_month = clone static::$_date;
		$prev_month->modify('-1 month');
		$date_info = getdate($prev_month->format('U'));
		return \Html::anchor(static::$nav_uri.'/'.$date_info['year'].'/'.$date_info['mon'], $text);
	}
	
	public static function next_month_link($text = '>>')
	{
		$next_month = clone static::$_date;
		$next_month->modify('+1 month');
		$date_info = getdate($next_month->format('U'));
		return \Html::anchor(static::$nav_uri.'/'.$date_info['year'].'/'.$date_info['mon'], $text);
	}
	
	/**
	 * Returns a DateTime object no matter what you throw at it
	 */
	public static function parse_date()
	{
		$args = func_get_args();
		$date = new \DateTime;
		switch (count($args))
		{
			case 1:
				if (is_string($args[0])) $date = \DateTime::createFromFormat(strtotime($args[0]), 'U');
				elseif (is_object($args[0]) and is_a($args[0], 'DateTime')) return $args[0];
			break;
			case 2:
				if (is_string($args[0])) $date = \DateTime::createFromFormat($args[0], $args[1]);
				else
					$date->setDate($args[0], $args[1]);
			break;
			case 3:
				$date->setDate($args[0], $args[1], $args[2]);
		}
		return ( ! $date) ? new \DateTime : $date;
	}
	
	public static function same_day($date1, $date2)
	{
		$date1->setTime(0,0,0);
		$date2->setTime(0,0,0);
		return $date1 == $date2;
	}

}
