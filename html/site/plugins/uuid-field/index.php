<?php

/**
 * Calling {{ page.uuid.id }} in an info field leads to problems 
 * if you want to publish a page on creation. This custom field 
 * is a safe way to show a page UUID.
 */

Kirby\Cms\App::plugin('philipmarnef/display-uuid-field', [

	'fields' => [
		'uuiddisplay' => [],
	],
]);
