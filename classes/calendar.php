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
	
	public static function factory($year=null, $month=null, $day=null)
	{
		return new static($year, $month, $day);
	}

	public function __construct($options = null)
	{
		// Set options
		if (is_array($options)) foreach($options_date_string_year as $key => $value)
		{
			$this->{$key} = $value;
		}
		else static::$_date = static::parse_date(func_get_args());
		
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
		$date = static::$_date;
		$active_month = clone $date;
		$num_days = (int) $date->format('t');
		$date->modify('first day of this month');
		$days_offset_start = array_search($date->format('l'), static::$weekdays);
		//\Debug::dump($num_days, $days_offset_start, static::$_date, static::$weekdays, $date->format('l'));
		$date->modify('-'.$days_offset_start.' days');
		$num_rows = ceil(($num_days + $days_offset_start) / 7);
		$days_offset_end = $num_rows * 7 - $num_days - $days_offset_start;
		$rows = array();
		for ($i=0; $i < $num_rows; $i++)
		{
			$rows[] = array();
			for ($d=0; $d < 7; $d++)
			{
				$rows[$i][$d] = false;
				$rows[$i][$d] = new Calendar_Day(clone $date, array(
					'events' => $this->get_events($date),
					'active_month' => ($date->format('n') == $active_month->format('n')),
				));
				$date->modify('+1 day');
			}
		}
		
		// Reset back to the correct month
		$date = $active_month;
		static::date($date);
		
		// Create View
		$view = $view ? $view : \Config::get('calendar.template_month', 'month_template');
		$view = \View::factory($view, array(
			'day_rows' => $rows, 
			'month' => $date->format('F'), 
			'year' => $date->format('Y'),
			'date' => $date
		), false);
		
		return $view;
	}
	
	public function set_date($year = null, $month = null, $day = null)
	{
		static::$_date = is_null($month) ? new \DateTime : static::parse_date($year, $month, $day);
		return $this;
	}
	
	public function date($date = null)
	{
		if ($date) 
		{
			static::$_date = static::parse_date($date);
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
		! is_a($event, 'Calendar_Event') and $event = Calendar_Event::factory($event);
		
		// Get more detailed info on the date
		$date = static::parse_date($date);
		$this->_events[$date->format('Y')][$date->format('n')][$date->format('j')][] = $event;
		return $this;
	}
	
	public function get_events($date)
	{
		$date = static::parse_date($date);
		$events = @$this->_events[$date->format('Y')][$date->format('n')][$date->format('j')];
		return $events ? $events : array();
	}
	
	public static function prev_month_link($text = '<<')
	{
		$prev_month = clone static::$_date;
		$prev_month->modify('-1 month');
		return \Html::anchor(static::$nav_uri.'/'.$prev_month->format('Y').'/'.$prev_month->format('m'), $text);
	}
	
	public static function next_month_link($text = '>>')
	{
		$next_month = clone static::$_date;
		$next_month->modify('+1 month');
		return \Html::anchor(static::$nav_uri.'/'.$next_month->format('Y').'/'.$next_month->format('m'), $text);
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
					$date->setDate((int) $args[0], (int) $args[1]);
			break;
			case 3:
				$date->setDate((int) $args[0], (int) $args[1], isset($args[2]) ? (int) $args[2] : 1);
		}
		return ( ! $date) ? new \DateTime : $date;
	}
	
	public static function same_day($date1, $date2 = null)
	{
		! $date2 and $date2 = new \DateTime;
		$date1->setTime(0,0,0);
		$date2->setTime(0,0,0);
		return $date1 == $date2;
	}

}
