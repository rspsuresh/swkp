<table class="uk-table">
	<tbody>
	<?php
		foreach($returnvalue as $key=>$value){
	?>		
		<tr>
			<td>
			<?php
				switch ($key) {
					case 0:
						echo "<b>Prepping :</b>";
						break;
					case 1:
						echo "<b>Prepping QC :</b>";
						break;
					case 2:
						echo "<b>Datecoding :</b>";
						break;
					case 3:
						echo "<b>Datecoding QC :</b>";
						break;
				}
			?>	
			</td>
            <td><?php echo implode(",",$value); ?></td>
        </tr>
	<?php
		}
	?>
    </tbody>
</table>
                  