<?php if ($entries !== FALSE): ?>
	<?php foreach ($entries as $entry): ?>

		<div id="<?php print $entry->entry_id; ?>" class="log_entry <?php print $events[$entry->event_id]->color; ?>">
			<h2 class="log_entry_time"><?php print $entry->date->format('F j, Y, g:i a'); ?></h2>
			<?php print anchor("entries/edit/{$entry->entry_id}", $events[$entry->event_id]->event_name); ?>
			<br />
			<?php print $entry->comments; ?>
		</div>

	<?php endforeach; ?>
<?php else: ?>
	<p><?php print $this->lang->line('entries_no_entries_found'); ?></p>
<?php endif; ?>

<div id="events" class="event_button">
	<?php print anchor('events', $this->lang->line('events')); ?>
</div>

<div id="admin_button" class="event_button">
	<?php print anchor('admin', $this->lang->line('admin')); ?>
</div>