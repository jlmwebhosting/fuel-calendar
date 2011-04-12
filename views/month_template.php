<style>
.calendar {
	border-collapse: separate;
	border: 1px solid #9DABCE;
	border-width: 0px 0px 1px 0px;
	margin-left: 40px;
	font-size: 20px;
	float: left;
}
.calendar th.month {
	height: 30px;
	font-weight: bold;
	font-size: 1.4em;
	background: none;
	color: #414141;
	border: none;
}
.calendar th.weekday {
	color: #fff;
	font-size: 0.6em;
	font-weight: normal;
	height: 30px;
}
.calendar thead tr {
	border: none;
}
.calendar thead td, .calendar thead td:hover {
	height: auto;
	background: none;
	font-size: medium;
	border: none;
	cursor: default;
}
.calendar td {
	width: 79px;
	height: 81px;
	text-align: center;
	vertical-align: middle;
	color: #909090;
	position: relative;
	padding: 0;
	
	background-color: #c2cad4;
	background-image: -moz-linear-gradient(100% 100% 90deg, #b9c1ca, #cad3de);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#cad3de), to(#b9c1ca));
	border: 1px solid;
	border-color: #dbdfe4 #9dacbe #9dacbe #dbdfe4;
}
.ie .calendar td {
	background: url(calendar/cells.png);
}
.calendar td.day.active {
	color: #414141;
	cursor: pointer;	
}
.calendar td.active.day:hover {
	background-position: 0px -81px;
	background-color: #d0d8e3;
	background-image: -moz-linear-gradient(100% 100% 90deg, #b9c1ca, #e5eefb);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#e5eefb), to(#b9c1ca));
	color: #000;
	border-color: #ebf0f6 #9dacbe #9dacbe #ebf0f6;
}
.calendar td.selected {
	background-position: 162px 0px;
	background-color: #BED95F;
	background-image: -moz-linear-gradient(100% 100% 90deg, #9db34e, #BED95F);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#BED95F), to(#9db34e));
	color: #F2F2F2;
	border-color: #90c2f3 #9dacbe #9dacbe #90c2f3;
}
.calendar td.active.today {
	background-position: 81px 0px;
	background: #76883f;
	box-shadow:inset 0 0 14px #000000;
	-moz-box-shadow:inset 0 0 14px #000000;
	-webkit-box-shadow:inset 0 0 14px #000000;
	color: #F2F2F2;
	border-color: #414141 #414141 #000000 #000000;
}
/*table.calendar td.active.today:hover {
	background-position: 81px -81px;
	background-color: #BED95F;
}*/
table.calendar td.padding {
	background-color: #d8dee5;
	background-image: -moz-linear-gradient(100% 100% 90deg, #f1f6fc, #c2cad5);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#c2cad5), to(#f1f6fc));
	border-left: 1px solid #e6ebf1;
	border-right: 1px solid #9dadbd;
	cursor:default;
}
.ie table.calendar td.padding {
	background: url(calendar/calpad.jpg);
}
table.calendar .events {
	position: relative;
}
table.calendar .events ul {
	text-align: left;
	position: absolute;
	display: none;
	z-index: 1000;
	padding: 15px;
	background: #E7ECF2 url(calendar/popup.png) no-repeat;
	color: white;
	border: 1px solid white;
	font-size: 15px;
	width: 200px;
	-moz-border-radius: 3px;
	-khtml-border-radius: 3px;
	-webkit-border-radius: 3px;
	-border-radius: 3px;
	list-style: none;
	color: #444444;
	-webkit-box-shadow: 0px 8px 8px #333;
}
table.calendar .events li {
	padding-bottom: 5px;
}
table.calendar .events li span {
	display: block;
	font-size: 12px;
	text-align: justify;
	color: #555;
}
table.calendar .events li span.title {
	font-weight: bold;
	color: #222;
}

</style>
<table class="calendar month">
	<thead>
		<tr>
			<td align="left"><?php echo Calendar::prev_month_link(); ?></td>
			<th align="center" colspan="5" class="month"><?php echo $month; ?></th>
			<td align="right"><?php echo Calendar::next_month_link(); ?></td>
		</tr>
		<tr>
			<?php foreach (Calendar::$weekdays as $weekday): ?>
			<th align="center" class="weekday"><?php echo $weekday; ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($day_rows as $row): ?>
		<tr class="row">
			<?php foreach ($row as $key => $day): if ($day): ?>
			<td class="<?php echo $day->get_classes(); ?>"><?php echo $day->format('j'); ?></td>
			<?php else: ?>
			<td class="blank"></td>
			<?php endif; endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>