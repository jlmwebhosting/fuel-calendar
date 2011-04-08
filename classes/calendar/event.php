<?php

namespace Calendar;

class Calendar_Event {
	
	protected $_date;
	public $title;
	public $description;
	public $location;
	
	public static function factory($options = null)
	{
		return new Calendar_Event($options);
	}
	
	public function __construct($options = null)
	{
		$this->create($options);
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
	
	public function create($options)
	{
		if ( ! $options) return $this;
		foreach ($options as $property => $value)
		{
			$this->{$property} = $value;
		}
	}
	
	public function date($date = null)
	{
		if ( ! $date) return $this->_date;
		
		is_object($date) and $this->_date = $date;
		is_string($date) and $this->_date = DateTime::createFromFormat(strtotime($date), 'U');
		
		return $this;
	}
	
}