import { test, expect } from '@playwright/test';
import { chromium } from 'playwright';

import {
	createProduct,
	doesProductExist,
} from '../utils/helper';
import {
	listCatalog,
	deleteAllCatalogItems,
	retrieveInventoryCount,
	extractCatalogInfo,
	clearSync
} from '../utils/square-sandbox';

test.beforeAll( 'Setup', async ( { baseURL } ) => {
	const browser = await chromium.launch();
	const page = await browser.newPage();

	await deleteAllCatalogItems();
	await page.goto( '/wp-admin/admin.php?page=wc-settings&tab=square&section' );
	await page.locator( '#wc_square_system_of_record' ).selectOption( { label: 'WooCommerce' } );
	await page.locator( '#wc_square_enable_inventory_sync' ).check();
	await page.locator( '.woocommerce-save-button' ).click();

	await clearSync( page );

	if ( ! ( await doesProductExist( baseURL, 'oneplus-8' ) ) ) {
		await createProduct(
			page, {
				name: 'OnePlus 8',
				regularPrice: '299',
				sku: 'oneplus-8',
			},
			false
		);

		await page.locator( '#_manage_stock' ).check();
		await page.locator( '#_stock' ).fill( '56' );
		await page.locator( '.general_tab' ).click();
		await page.locator( '#_wc_square_synced' ).check();
		await page.waitForTimeout( 2000 );
		await page.locator( '#publish' ).click();
	}

	await browser.close();
} );

test( 'OnePlus 8 pushed to Square with inventory', async ( { page } ) => {
	test.slow();

	await page.goto( '/wp-admin/admin.php?page=wc-settings&tab=square&section=update' );

	const result = await new Promise( ( resolve ) => {
		let intervalId = setInterval( async () => {
			const __result = await listCatalog();

			if ( __result.objects ) {
				clearInterval( intervalId );
				resolve( __result );
			}
		}, 3000 );
	} );

	const {
		name,
		variations,
	} = extractCatalogInfo( result.objects[0] );

	expect( name ).toEqual( 'OnePlus 8' );
	expect( variations[ 0 ].sku ).toEqual( 'oneplus-8' );
	expect( variations[ 0 ].price ).toEqual( 29900 );

	let inventory = await retrieveInventoryCount( variations[ 0 ].id );

	if ( ! inventory.counts ) {
		await new Promise( ( resolve ) => {
			setInterval( () => {
				inventory = retrieveInventoryCount( variations[ 0 ].id );
				if ( inventory.counts ) {
					resolve();
				}
			}, 4000 );
		} );
	}

	expect( inventory ).toHaveProperty( 'counts' );
	expect( inventory ).toHaveProperty( 'counts[0].quantity', '56' );
} );
