<?php

namespace Calendar;

class Calendar_Day {

	protected $_date;
	public $date_info;
	public $content;
	public $events = array();
	protected $_weekday;
	
	public function __construct($date, $options)
	{
		$this->date($date);
		foreach ($options as $property => $value)
		{
			$this->$property = $value;
		}
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
	
	public function date($date = null)
	{
		if ( ! $date) return $this->_date;
		
		$this->_date = Calendar::parse_date($date);
		$this->date_info = getdate($this->_date->format('U'));
		
		return $this;
	}
	
	public function get_classes()
	{
		$classes = 'day '.strtolower($this->date_info['weekday']);
		$this->has_events() and $classes .= ' has_events';
		return $classes;
	}
	
	public function has_events()
	{
		return (bool) count($this->events);
	}
	
	public function is_today()
	{
		return false;///TODO
	}

}