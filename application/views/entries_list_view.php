<?php if ($events !== FALSE): ?>
	<?php foreach ($events as $event): ?>

		<div id="<?php print $event->event_id; ?>" class="log_entry <?php print $event->color; ?>">
			<h2 class="event_title"><?php print $event->event_name; ?></h2>
			<?php print anchor("events/edit/{$event->event_id}", $this->lang->line('form_edit')); ?>
			<br />
			<?php print anchor("events/delete/{$event->event_id}", $this->lang->line('form_delete')); ?>
			<br />
			<?php print $event->description; ?>
		</div>

	<?php endforeach; ?>
<?php else: ?>
	<p><?php print $this->lang->line('events_no_events_found'); ?></p>
<?php endif; ?>

<div id="admin_button" class="event_button">
	<?php print anchor('admin', $this->lang->line('admin')); ?>
</div>