<div id="event_columns">
	<?php if ($events !== FALSE): ?>
		<?php foreach ($events as $event): ?>

			<div id="<?php print $event->event_id; ?>" class="event_button">
				<?php print anchor("entries/add/{$event->event_id}", $event->event_name, array('class' => $event->color)); ?>
			</div>

		<?php endforeach; ?>
	<?php else: ?>
		<p><?php print $this->lang->line('events_no_events_found'); ?></p>
	<?php endif; ?>

	<div id="history" class="event_button">
		<?php print anchor('entries/history', $this->lang->line('history'), array('class' => 'gray')); ?>
	</div>

	<div id="admin_button" class="event_button">
		<?php print anchor('admin', $this->lang->line('admin'), array('class' => 'gray')); ?>
	</div>
</div>