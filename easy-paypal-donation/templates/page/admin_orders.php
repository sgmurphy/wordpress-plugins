<style>
    .check-column {
        width: 2% !important;
    }
    .column-order {
        width: 10%;
    }
    .column-item {
        width: 10%;
    }
    .column-amount {
        width: 10%;
    }
    .column-status {
        width: 12%;
    }
</style>

<div style="width:98%">

	<table width="100%">
		<tr>
			<td>
				<br />
				<span style="font-size:20pt;">Donations</span>
            </td>
			<td valign="bottom">
			</td>
		</tr>
	</table>

	<?php
	if (isset($_GET['message'])):
		switch ($_GET['message']) {
			case 'deleted':
				echo "<div class='error'><p>Donation entry(s) deleted.</p></div>";
				break;
            case 'not_found':
				echo "<div class='error'><p>Donation not found</p></div>";
				break;
			case 'nothing':
				echo "<div class='error'><p>No action selected.</p></div>";
				break;
			case 'nothing_deleted':
				echo "<div class='error'><p>Nothing selected to delete.</p></div>";
				break;
			case 'error':
				echo "<div class='error'><p>An error occured while processing the query. Please try again.</p></div>";
		}
	endif; ?>

	<form id="products-filter" method="get">
		<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
		<?=$args['table'];?>
	</form>
</div>