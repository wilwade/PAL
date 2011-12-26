<div id="event_columns">
	<?php if ($events !== FALSE): ?>
		<?php foreach ($events as $event): ?>

			<div id="<?php print $event->event_id; ?>" class="event_button">
				<a href="entry/add/<?php print $event->event_id; ?>">
					<?php print $event->event_name; ?>
				</a>
			</div>

		<?php endforeach; ?>
	<?php else: ?>
		<p><?php print $this->lang->line('events_no_events_found'); ?></p>
	<?php endif; ?>

	<div id="history" class="event_button">
		<a href="entry/log">
			History
		</a>
	</div>

	<div id="admin_button" class="event_button">
		<a href="admin">
			Admin
		</a>
	</div>
</div>