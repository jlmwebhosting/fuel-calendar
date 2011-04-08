<?php

Autoloader::add_core_namespace('Calendar');

Autoloader::add_classes(array(
	'Calendar\\Calendar'        => __DIR__ . '/classes/calendar.php',
	'Calendar\\Calendar_Day'  => __DIR__ . '/classes/calendar/day.php',
	'Calendar\\Calendar_Event'  => __DIR__ . '/classes/calendar/event.php',
));
