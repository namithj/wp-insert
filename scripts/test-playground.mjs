/**
 * Smoke test for a built Playground bundle.
 *
 * Checks the things that actually break a demo: a missing or malformed
 * blueprint, a plugin zip that does not contain the plugin, and a blueprint
 * whose steps point at resources the bundle does not carry. It deliberately
 * does not boot Playground — that needs a browser — so it stays fast enough to
 * run on every release.
 *
 * Usage: node scripts/test-playground.mjs <bundle-zip>
 */

import { execFileSync } from 'node:child_process';
import { existsSync, mkdtempSync, rmSync, writeFileSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';

const REQUIRED_ENTRIES = [ 'blueprint.json', 'wp-insert.zip' ];

function fail( message ) {
	console.error( `Playground bundle check failed: ${ message }` );
	process.exit( 1 );
}

function readEntry( bundlePath, entry ) {
	return execFileSync( 'unzip', [ '-p', bundlePath, entry ], {
		encoding: 'utf8',
		maxBuffer: 64 * 1024 * 1024,
	} );
}

function listEntries( bundlePath ) {
	return execFileSync( 'unzip', [ '-Z1', bundlePath ], { encoding: 'utf8' } )
		.split( '\n' )
		.map( ( line ) => line.trim() )
		.filter( Boolean );
}

const [ bundlePath ] = process.argv.slice( 2 );

if ( ! bundlePath ) {
	fail( 'Usage: node scripts/test-playground.mjs <bundle-zip>' );
}

if ( ! existsSync( bundlePath ) ) {
	fail( `bundle not found at ${ bundlePath }` );
}

const entries = listEntries( bundlePath );

for ( const required of REQUIRED_ENTRIES ) {
	if ( ! entries.includes( required ) ) {
		fail( `bundle is missing ${ required } (found: ${ entries.join( ', ' ) })` );
	}
}

let blueprint;
try {
	blueprint = JSON.parse( readEntry( bundlePath, 'blueprint.json' ) );
} catch ( error ) {
	fail( `blueprint.json is not valid JSON — ${ error.message }` );
}

if ( ! Array.isArray( blueprint.steps ) || blueprint.steps.length === 0 ) {
	fail( 'blueprint has no steps' );
}

const installStep = blueprint.steps.find( ( step ) => step.step === 'installPlugin' );

if ( ! installStep ) {
	fail( 'blueprint does not install the plugin' );
}

// A bundled resource must correspond to a file actually inside the bundle,
// otherwise Playground fails at load time with an opaque error.
if ( installStep.pluginData?.resource === 'bundled' ) {
	const bundledPath = String( installStep.pluginData.path || '' ).replace( /^\//, '' );

	if ( ! entries.includes( bundledPath ) ) {
		fail( `blueprint references bundled '${ bundledPath }' which is not in the bundle` );
	}
}

if ( installStep.options?.activate !== true ) {
	fail( 'blueprint does not activate the plugin' );
}

const runPhpStep = blueprint.steps.find( ( step ) => step.step === 'runPHP' );

if ( ! runPhpStep || ! runPhpStep.code?.includes( '<?php' ) ) {
	fail( 'blueprint is missing the demo-content runPHP step' );
}

// The demo seeds ad units directly into options; if those option names ever get
// renamed the demo would silently show an empty page instead of ads.
for ( const option of [ 'wp_insert_inpostads', 'wp_insert_shortcodeads' ] ) {
	if ( ! runPhpStep.code.includes( option ) ) {
		fail( `demo setup no longer seeds ${ option }` );
	}
}

// Ad code is passed through do_shortcode(), so literal shortcode syntax in the
// demo creatives would be expanded away rather than displayed.
if ( /\[wpinsert\w*/.test( runPhpStep.code.replace( /\[wpinsertshortcodead id=/g, '' ) ) ) {
	fail( 'demo ad creatives contain literal shortcode syntax, which do_shortcode() would strip' );
}

// The plugin zip must actually contain the plugin's main file. Extract the inner
// zip to a temporary file so it can be listed with unzip in turn.
const workDir = mkdtempSync( join( tmpdir(), 'wp-insert-playground-' ) );
const innerZip = join( workDir, 'wp-insert.zip' );
let pluginEntries;

try {
	writeFileSync(
		innerZip,
		execFileSync( 'unzip', [ '-p', bundlePath, 'wp-insert.zip' ], {
			maxBuffer: 256 * 1024 * 1024,
		} )
	);
	pluginEntries = listEntries( innerZip );
} finally {
	rmSync( workDir, { recursive: true, force: true } );
}

if ( ! pluginEntries.includes( 'wp-insert/wp-insert.php' ) ) {
	fail( 'plugin zip does not contain wp-insert/wp-insert.php' );
}

if ( pluginEntries.some( ( entry ) => entry.startsWith( 'wp-insert/tests/' ) ) ) {
	fail( 'plugin zip contains development files (tests/)' );
}

console.log(
	`Playground bundle OK — ${ entries.length } bundle entries, ` +
		`${ pluginEntries.length } plugin files, ${ blueprint.steps.length } blueprint steps.`
);
