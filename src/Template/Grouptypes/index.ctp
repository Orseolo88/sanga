<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		<li><?= $this->Html->link(__('New Grouptype'), ['action' => 'add']) ?></li>
	</ul>
</div>
<div class="grouptypes index large-10 medium-9 columns">
	<table cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th><?= $this->Paginator->sort('id') ?></th>
			<th><?= $this->Paginator->sort('name') ?></th>
			<th class="actions"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($grouptypes as $grouptype): ?>
		<tr>
			<td><?= $this->Number->format($grouptype->id) ?></td>
			<td><?= h($grouptype->name) ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['action' => 'view', $grouptype->id]) ?>
				<?= $this->Html->link(__('Edit'), ['action' => 'edit', $grouptype->id]) ?>
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grouptype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouptype->id)]) ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<div class="paginator">
		<ul class="pagination">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'));
			echo $this->Paginator->numbers();
			echo $this->Paginator->next(__('next') . ' >');
		?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>
</div>
