<div id="event_columns">
	<div id="event_add" class="event_button">
		<?php print anchor('events/add', $this->lang->line('admin_add_event'), array('class' => 'gray')); ?>
	</div>
	<div id="event_list" class="event_button">
		<?php print anchor('events/all', $this->lang->line('admin_list_events'), array('class' => 'gray')); ?>
	</div>
	<div id="password_change" class="event_button">
		<?php print anchor('admin/password', $this->lang->line('admin_change_password'), array('class' => 'gray')); ?>
	</div>
	<div id="events" class="event_button">
	<?php print anchor('events', $this->lang->line('events'), array('class' => 'gray')); ?>
	</div>
	<div id="history" class="event_button">
		<?php print anchor('entries/history', $this->lang->line('history'), array('class' => 'gray')); ?>
	</div>
	<div id="logout" class="event_button">
		<?php print anchor('admin/logout', $this->lang->line('admin_logout'), array('class' => 'gray')); ?>
	</div>
</div>