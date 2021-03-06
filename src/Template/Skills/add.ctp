<div class="sidebar-wrapper">
	<nav class="side-nav">
		<ul>
			<li><?= $this->Html->link(__('List Skills'), ['action' => 'index']) ?></li>
			<li><?= $this->Html->link(__('List Contacts'), ['controller' => 'Contacts', 'action' => 'index']) ?> </li>
			<li><?= $this->Html->link(__('New Contact'), ['controller' => 'Contacts', 'action' => 'add']) ?> </li>
		</ul>
	</nav>
</div>
<!-- sidebar wrapper -->

<div class="content-wrapper">
	<div class="row">
		<div class="skills form large-10 medium-9 columns">
		<?= $this->Form->create($skill) ?>
			<fieldset>
				<legend><?= __('Add Skill') ?></legend>
			<?php
				echo $this->Form->input('name');
				echo $this->Form->input('contacts._ids', ['options' => $contacts]);
			?>
			</fieldset>
		<?= $this->Form->button(__('Submit')) ?>
		<?= $this->Form->end() ?>
		</div>
	</div>
</div>
