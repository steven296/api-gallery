<?php

namespace BestShop\v1;

use Db;
use BestShop\Route;
use BestShop\Database\DbQuery;
use BestShop\Album\Album as AlbumObject;
use BestShop\Util\ArrayUtils;
use BestShop\Validate;

class Album extends Route {
	public function getAlbums() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('album.*');
		// Build FROM
		$sql->from('album', 'album');
		$albums = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'albums' => $albums
		]);
	}

	public function addAlbum() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$description = ArrayUtils::get($payload, 'description');

		if (!Validate::isCatalogName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid album name'
			]);
		}

		if (!Validate::isCleanHtml($description)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid description of the album'
			]);
		}

		$album = new AlbumObject();
		$album->name = $name;
		$album->description = $description;

		$ok = $album->save();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to create album'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'album was created',
			'album' => [
				'album_id' => $album->id,
				'name' => $album->name,
				'description' => $album->description,
			]
		]);
	}

}	