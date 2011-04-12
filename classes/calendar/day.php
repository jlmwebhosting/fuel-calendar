<?php

namespace Calendar;

class Calendar_Day {

	protected $_date;
	public $content;
	public $events = array();
	public $active_month = true;
	
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
		
		return $this;
	}
	
	public function get_classes()
	{
		$classes = 'day '.strtolower($this->_date->format('l'));
		$this->has_events() and $classes .= ' has_events';
		$this->is_today() and $classes .= ' today';
		$this->active_month and $classes .= ' active';
		return $classes;
	}
	
	public function has_events()
	{
		return (bool) count($this->events);
	}
	
	public function is_today()
	{
		return Calendar::same_day($this->_date);
	}
	
	public function format($pattern)
	{
		return $this->_date->format($pattern);
	}

}