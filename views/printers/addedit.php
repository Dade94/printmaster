<?php
$tpl->set('title', ($action == 'add') ? 'Add printer' : 'Edit printer: ' . $p->getName());
$tpl->place('header');
?>

<div class="grid_12">

	<form action="<?php echo fURL::get() ?>" method="post">
	<input type="hidden" name="action" value="<?php echo $action ?>" />
	<input type="hidden" name="id" value="<?php echo $p->getId() ?>" />

		<table class="form">

			<tr>
				<td class="caption"><label for="model_id">Model</label></td>
				<td class="input"><select name="model_id"><?php
					foreach($models as $m){
						$selected = ($m->id == $p->getModelId()) ? ' selected="selected"' : '';
						printf('<option value="%d"%s>%s</option>',
							$m->id,
							$selected,
							$m->mfr_name . ' ' . $m->model_name
						);
					}
				?></select></td>
			</tr>

			<tr>
				<td class="caption"><label for="name">Name</label></td>
				<td class="input">
					<input id="name" type="text" name="name" value="<?php echo $p->getName() ?>"
					maxlength="<?php echo $p->inspectName('max_length') ?>" />
				</td>
			</tr>

			<tr>
				<td class="caption"><label for="location">Location</label></td>
				<td class="input">
					<input id="location" type="text" name="location" value="<?php echo $p->getLocation() ?>"
					maxlength="<?php echo $p->inspectLocation('max_length') ?>" />
				</td>
			</tr>

			<tr>
				<td class="caption"><label for="department">Department</label></td>
				<td class="input">
					<input id="department" type="text" name="department" value="<?php echo $p->getDepartment() ?>"
					maxlength="<?php echo $p->inspectDepartment('max_length') ?>" />
				</td>
			</tr>

			<tr>
				<td class="caption"><label for="ipaddress">IP Address</label></td>
				<td class="input">
					<input id="ipaddress" type="text" name="ipaddress" value="<?php echo $p->getIpaddress() ?>"
					maxlength="<?php echo $p->inspectIpaddress('max_length') ?>" />
				</td>
			</tr>

			<tr>
				<td class="caption"><label for="server">Print server</label></td>
				<td class="input">
					<input id="server" type="text" name="server" value="<?php echo $p->getServer() ?>"
					maxlength="<?php echo $p->inspectServer('max_length') ?>" />
				</td>
			</tr>

			<tr>
				<td class="caption"><label for="serial">Serial number</label></td>
				<td class="input">
					<input id="serial" type="text" name="serial" value="<?php echo $p->getSerial() ?>"
					maxlength="<?php echo $p->inspectSerial('max_length') ?>" />
				</td>
			</tr>

			<?php if (feature('costs')): ?>
			<tr>
				<td class="caption middle"><label for="cost">Purchase cost</label></td>
				<td class="input">
					<span class="currency"><?php echo config_item('currency') ?></span>
					<input id="cost" type="text" name="cost" value="<?php echo $p->getCost() ?>" maxlength="10" size="10" />
				</td>
			</tr>
			<?php endif; ?>

			<tr>
				<td class="caption middle"><label for="cost">Purchase date</label></td>
				<td class="input">
					<input type="text" class="text-input datepicker" name="purchase_date" value="<?php echo $p->getPurchaseDate() ?>" maxlength="10" size="15">
				</td>
			</tr>

			<?php if (feature('tags')): ?>
			<tr>
				<td class="caption"><label for="tags">Tags</label></td>
				<td class="input">
					<div class="clearfix">
						<select class="tags" multiple="multiple" name="tags[]" id="tags">
							<?php
							$p_tags = $p->buildTags();
							foreach ($tags as $tag)
							{
								$selected = ($p_tags->contains($tag) ? 'selected="selected"' : '');
								echo "<option $selected value='" . $tag->getId() . "'>" . $tag->getTitle() . "</option>";
							}
							?>
						</select>
					</div>
					<button type="button" class="js-new-tag">New</button>
				</td>
			</tr>
			<?php endif; ?>

			<tr>
				<td class="caption"><label for="notes">Notes</label></td>
				<td class="input">
					<textarea id="notes" name="notes" rows="6" cols="40"><?php echo $p->getNotes() ?></textarea>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>
					<button type="submit" name="next" class="btn btn_pos" value="index"><?php echo ($action == 'add') ? 'Add' : 'Save'; ?></button>

					<?php if ($action === 'add'): ?>
					<button type="submit" name="next" class="btn btn_misc" value="add">Add new + another</button>
					<?php endif; ?>

					<?php if($action == 'edit'): ?>
					<a href="printers.php?action=delete&amp;id=<?php echo $p->getId() ?>" class="btn btn_neg">Delete</a>
					<?php endif; ?>
				</td>
			</tr>

		</table>

	</form>

</div>

<script type="text/javascript">
$(document).ready(function(){
	$(".datepicker").Zebra_DatePicker({ direction: false });
	$("input[name='name']").focus();
});
</script>

<?php if (feature('tags')): ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#tags").bsmSelect({
		title: 'Select ...',
		removeLabel: '<strong>X</strong>',
		addItemTarget: 'original',
		containerClass: 'bsmContainer',                // Class for container that wraps this widget
		listClass: 'bsmList-tags',                   // Class for the list ($ol)
		listItemClass: 'bsmListItem-tags',           // Class for the <li> list items
		listItemLabelClass: 'bsmListItemLabel-tags', // Class for the label text that appears in list items
		removeClass: 'bsmListItemRemove-tags'       // Class given to the "remove" link
	});

	$(".js-new-tag").on("click", function() {
		var tag = prompt("Name of new tag");
		$("#tags").append($("<option>", { text: tag, selected: "selected"})).change();
	});
})
</script>
<?php endif; ?>

<?php
$tpl->place('footer');
?>
