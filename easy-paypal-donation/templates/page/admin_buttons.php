<style>
    .check-column {
        width: 2% !important;
    }
    .column-product {
        width: 25%;
    }
    .column-shortcode {
        width: 35%;
    }
    .column-price {
        width: 25%;
    }
    .column-sku {
        width: 13%;
    }
</style>

<div style="width:98%">
	<table width="100%">
		<tr>
			<td>
				<br />
				<span style="font-size:20pt;">Easy Donation Buttons</span>
			</td>
			<td valign="bottom">
				<a href="?page=wpedon_buttons&action=new" name='btn2' class='button-primary' style='font-size: 14px;height: 30px;float: right;'>New PayPal Donation Button</a>
			</td>
		</tr>
	</table>

	<?php
	if (isset($_GET['message'])) {
		switch ($_GET['message']) {
			case 'created':
				echo "<div class='updated'><p>Button created.</p></div>";
				break;
			case 'deleted':
				echo "<div class='updated'><p>Button(s) deleted.</p></div>";
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
	} ?>

	<form id="products-filter" method="get">
		<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
		<?=$args['table']; ?>
	</form>
</div>