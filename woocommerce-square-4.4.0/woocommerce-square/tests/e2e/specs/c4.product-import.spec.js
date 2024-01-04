import { test, expect } from '@playwright/test';
import { chromium } from 'playwright';

import {
	doesProductExist,
	deleteAllProducts,
} from '../utils/helper';
import {
	deleteAllCatalogItems,
	createCatalogObject,
	updateCatalogItemInventory,
	importProducts,
	clearSync
} from '../utils/square-sandbox';

let itemId = 0;

test.beforeAll( 'Setup', async () => {
	const browser = await chromium.launch();
	const page = await browser.newPage();

	await deleteAllProducts( page );
	await deleteAllCatalogItems();
	const response = await createCatalogObject( 'Cap', 'cap', 1350, 'This is a very good cap, no cap.' );
	itemId = response.catalog_object.item_data.variations[0].id;

	await updateCatalogItemInventory( itemId, '53' );
	await clearSync( page );

	await page.goto( '/wp-admin/admin.php?page=wc-settings&tab=square' );
	await page.locator( '#wc_square_system_of_record' ).selectOption( { label: 'Square' } );
	await page.locator( '.woocommerce-save-button' ).click();
	await expect( await page.getByText( 'Your settings have been saved.' ) ).toBeVisible();

	await browser.close();
} );

test( 'Import Cap from Square', async ( { page, baseURL } ) => {
	test.slow();

	await importProducts( page );

	await new Promise( ( resolve ) => {
		let intervalId = setInterval( async () => {
			if ( await doesProductExist( baseURL, 'cap' ) ) {
				clearInterval( intervalId );
				resolve();
			}
		}, 4000 );
	} );

	await page.goto( '/product/cap' );
	await expect( await page.locator( '.entry-summary .woocommerce-Price-amount' ) ).toHaveText( '$13.50' );
	await expect( await page.locator( '.entry-summary .sku_wrapper' ) ).toHaveText( 'SKU: cap-regular' );
	await expect( await page.getByText( 'This is a very good cap, no cap.' ) ).toBeVisible();
	await expect( await page.getByText( '53 in stock' ) ).toBeVisible();
} );

test( 'Handle missing products', async ( { page } ) => {
	await deleteAllCatalogItems();
	await page.goto( '/wp-admin/admin.php?page=wc-settings&tab=square&section' );
	await page.locator( '#wc_square_hide_missing_products' ).check();
	await page.locator( '.woocommerce-save-button' ).click();
	await expect( await page.getByText( 'Your settings have been saved.' ) ).toBeVisible();
	await page.goto( '/wp-admin/admin.php?page=wc-settings&tab=square&section=update' );
	await page.locator( '#wc-square-sync' ).click();
	await page.locator( '#btn-ok' ).click();
	await expect( await page.getByText( 'Syncing now' ) ).toBeVisible();

	await page.goto( '/shop' );

	await new Promise( ( resolve ) => {
		let intervalId = setInterval( async () => {
			if ( await page.getByText( 'No products were found matching your selection.' ).isVisible() ) {
				clearInterval( intervalId );
				resolve();
			} else {
				await page.reload();
			}
		}, 4000 );
	} );

	await expect( await page.getByText( 'No products were found matching your selection.' ) ).toBeVisible();
} );
