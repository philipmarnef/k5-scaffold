<?php

return [

	'page.update:after' => function ( Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage ) {

		// update 'updated_on' field
		$update = [
			'updated_on' => date('Y-m-d H:i:s'),
		];

		// update 'updated_by' field
		if ( $user = $this->user() ) $updated['updated_by'] = $user->uuid()->toString();

		$newPage->update($update);

	}

];
