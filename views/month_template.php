<table class="calendar month">
	<thead>
		<tr>
			<td align="left"><?php echo Calendar::prev_month_link(); ?></td>
			<th align="center" colspan="5"><?php echo $month; ?></th>
			<td align="right"><?php echo Calendar::next_month_link(); ?></td>
		</tr>
		<tr>
			<?php foreach (Calendar::$weekdays as $weekday): ?>
			<td align="center" class="weekday"><?php echo $weekday; ?></td>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($day_rows as $row): ?>
		<tr class="row">
			<?php foreach ($row as $key => $day): if ($day): ?>
			<td class="<?php echo $day->get_classes(); ?>"><?php echo $day->date_info['mday']; ?></td>
			<?php else: ?>
			<td class="blank"></td>
			<?php endif; endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>