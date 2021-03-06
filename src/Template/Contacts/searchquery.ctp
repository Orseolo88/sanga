<?php
echo $this->Html->script('sanga.contacts.searchquery.js', ['block' => true]);
?>

<div class="sidebar-wrapper">
	<nav class="side-nav">
		<ul>
			<li><?= $this->Html->link(__('Save Query'), [], ['id' => 'savequery']) ?></li>
		</ul>
		<h6><?= __('Saved Queries') ?></h6>
		<ul id="savedqueries">
			<?php
			if (isset($savedQueries)) {
				foreach ($savedQueries as $q) {
					parse_str($q->value, $savedQuery);
					echo '<li>';
						echo $this->Html->link($savedQuery['qName'], ['action' => 'searchquery', $q->id]);
					echo '</li>';
				}
			}
				
			?>
		</ul>
	</nav>
	<div id="dialog">
		<?php
		echo $this->Form->create(null, ['id' => 'querySaveForm']);
		echo $this->Form->input('queryname',
								['class' => 'radius',
								 'type' => 'text']);
		echo $this->Form->button(__('Save'), ['class' => 'radius']);
		echo $this->Form->end();
		?>
	</div>
</div>
<!-- sidebar wrapper -->

<div class="content-wrapper">
	<div class="row">
		<div class="contacts index columns large-12">
			<h1>
				<?php
				echo __('Queries');
				if (isset($query['qName'])) {
					echo ' / ' . $query['qName'];
					unset($query['qName']);
					echo $this->Html->image('remove.png',
								['class' => 'ajaxremove',
								 'title' => __('Click to delete')]);

				}
				?>
			</h1>
			<?php
			echo $this->Form->create(null, [
											'type' => 'get',
											'id' => 'queryForm'
											]);
		
				echo '<div class="row" id="query-select-box">';
					echo '<h2>' . __('I want to see') . '</h2>';
					$filterFields = [
						'contactname' => __('Contactname'),
						'legalname' => __('Legalname'),
						'Zips.zip' => __('Zip'),
						'Zips.name' => __('City'),
						'address' => __('Address'),
						'phone' => __('Phone'),
						'email' => __('Email'),
						'birth' => __('Birth'),
						'sex' => __('Sex'),
						'workplace' => __('Workplace'),
						'WorkplaceZips.zip' => __('Workplace_zip'),
						'WorkplaceZips.name' => __('Workplace_city'),
						'workplace_address' => __('Workplace_address'),
						'workplace_phone' => __('Workplace_phone'),
						'workplace_email' => __('Workplace_email'),
						'Contactsources.name' => __('Contactsource'),
						'comment' => __('Comment'),
						'created' => __('Created'),
						'modified' => __('Modified')
						];
					foreach($filterFields as $field => $fLabel) {
						if ( ! empty($selected) && in_array($field, $selected)) {
							$css = 'tag-viewable';
						} else {
							$css = 'tag-default';
						}
						if (strpos($field, '.')) {
							$dataName = $field;
						} else {
							$dataName = 'Contacts.'.$field;
						}
						echo '<span class="tag ' . $css . '" data-name="' . $dataName . '">';
							echo $fLabel;
						echo '</span>';
					}
				echo '</div>';
				
				echo '<h2>' . __('Where') . '</h2>';
				echo '<div class="row" id="where">';
					if (isset($query)) {
						foreach ($query as $name => $values) {
							if ( ! is_array($values)) {		//connect
								if (strpos($name, 'connect_') === 0) {
									$dataName = str_replace('_', '.', str_replace('connect_', '', $name));
									if (substr($values, 0, 1)  == '&' || $values == ''){
										$img = 'and.png';
										$title = '*' . __('and') . '* ' . __('Click to change');
									} else {
										$img = 'or.png';
										$title = '*' . __('or') . '* ' . __('Click to change');
									}
									$connect[$dataName] = $this->Html->image($img,
																['class' => 'fl',
																 'title' => $title]);
									$connect[$dataName] .=	 '<input
													type="hidden"
													value="'. $value . '"
													name="connect_' . $dataName . '">';
								} 
							} else {
								foreach ($values as $vi => $value) {
									if (strpos($name, 'condition_') === 0) {
										if ($vi == 0) {
											$dataName = str_replace('_', '.', str_replace('condition_', '', $name));
											$imgPlus[$dataName] = $this->Html->image('plus.png',
																	['class' => 'fl',
																	 'data-name' => $dataName]);
											$label[$dataName] = '<label id="l' . str_replace('.', '_', $dataName) . '" for="' . $dataName . '">';
												$fName = str_replace('Contacts.', '', $dataName);
												$label[$dataName] .= $filterFields[$fName];
											$label[$dataName] .= '</label>';
			
											$selects[$dataName][] = $this->Form->select($name . '[]',
																	 ['&%' => __('contains'),
																	  '&=' => '=',
																	  '&!' => __('not'),
																	  '&<' => '<',
																	  '&>' => '>'],
																	 ['value' => $value]);
										} else {
											$selects[$dataName][] = $this->Form->select($name . '[]',
																	['---' . __('and') . '---' =>
																		['&%' => __('and') . ' ' . __('contains'),
																		 '&=' => __('and') . ' ' . '=',
																		 '&!' => __('and') . ' ' . __('not'),
																		 '&<' => __('and') . ' ' . '<',
																		 '&>' => __('and') . ' ' . '>'
																		]
																	,
																	'---' . __('or') . '---' =>
																		[
																		'|%' => __('or') . ' ' . __('contains'),
																		'|=' => __('or') . ' ' . '=',
																		'|!' => __('or') . ' ' . __('not'),
																		'|<' => __('or') . ' ' . '<',
																		'|>' => __('or') . ' ' . '>']
																	],
																	['value' => $value]);
											
										}
									} elseif (strpos($name, 'field_') === 0) {
										$inputs[$dataName][] = '<input
												type="text"
												name="field_' . $dataName . '[]"
												value="' . $value . '">';
									}
								}
							}
						}
						
						if (isset($imgPlus)) {
							foreach($imgPlus as $dataName => $x) {
								echo '<div data-name="' . $dataName . '">';
									if (isset($connect[$dataName])) {
										echo $connect[$dataName];
									}
									echo $imgPlus[$dataName];
									echo $label[$dataName];
									foreach ($selects[$dataName] as $i => $select) {
										echo $select;
										echo $inputs[$dataName][$i];
									}
								echo '</div>';
							}
						}
					}
				echo '</div>';
		
				echo $this->Form->button(__('Search'), ['class' => 'radius']);
			echo $this->Form->end();
			?>
		</div>
		
		<div class="contacts form large-10 medium-9 columns">
			<?php
			if (isset($contacts)){
				echo '<h2>' . __('Search results') . '</h2>';
				
				echo $this->element('contacts_table',
									[
									 'fields' => $selected,
									 'contacts' => $contacts,
									 'settings' => false,
									 'fieldNames' => $filterFields
									 ]);
			}
			?>
		
		</div>
	</div>
</div>