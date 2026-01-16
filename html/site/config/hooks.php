<?php

return [

	'page.update:after' => function ( Kirby\Cms\Page $newPage, Kirby\Cms\Page $oldPage ) {

		// only update the meta fields on pages that have them
		if ( $newPage->updated_on()->exists() && $newPage->updated_by()->exists() ) {

			$update ??= [];

			// update 'updated_on' field
			$update['updated_on'] = date('Y-m-d H:i:s');

			// update 'updated_by' field
			if ( $user = $this->user() ) $update['updated_by'] = $user->uuid()->toString();

			// use $page->save() to prevent an update hook loop
			$newPage = $newPage->save($update);

		}

	}

];
