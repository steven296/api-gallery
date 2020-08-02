<?php

namespace BestShop\v1;

use Db;
use BestShop\Route;
use BestShop\Database\DbQuery;
use BestShop\Image\Image as ImageObject;
use BestShop\Util\ArrayUtils;
use BestShop\Validate;

class Image extends Route {

	public function getImages() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('image.*');
		// Build FROM
		$sql->from('image', 'image');
		$images = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'images' => $images
		]);
	}
    
	public function addImage() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$description = ArrayUtils::get($payload, 'description');
		
		if (!Validate::isGenericName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'ingrese un nombre valido para la imagen'
			]);
		}

		if (!Validate::isCleanHtml($description)) {
			return $api->response([
				'success' => false,
				'message' => 'ingrese una descripcion valida para la imagen'
			]);
		}
		
		$image = new ImageObject();
		$image->name = $name;
		$image->description = $description;
		$image->image = '';

		$ok = $image->save();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to create image'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Image was Created',
			'image' => [
				'image_id' => $image->id,
				'name' => $image->name,
				'description' => $image->description,
				'image' => $image->image,
				'size' => $image->size,
				'extension' => $image->extension,
				'width' => $image->width,
				'height' => $image->height,
			]
		]);
	}
	
	public function getImage( $imageId ) {
		$api = $this->api;

		$image = new ImageObject( (int) $imageId );
		if(!Validate::isLoadedObject($image)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Image was not found'
			]);
		}
		
		return $api->response([
			'success' => true,
			'message' => 'Image was Created',
			'image' => [
				'image_id' => $image->id,
				'name' => $image->name,
				'description' => $image->description,
				'image' => $image->image,
				'size' => $image->size,
				'extension' => $image->extension,
				'width' => $image->width,
				'height' => $image->height,
			]
		]);
	}
	
	public function updateImage($imageId ) {
		$api = $this->api;
		$payload = $api->request()->post(); 
		
		$image = new ImageObject( (int) $imageId );
		if(!Validate::isLoadedObject($image)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Image was not found'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid image name'
				]);
			}

			$image->name = $name;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$description = ArrayUtils::get($payload, 'description');
			if (!Validate::isCleanHtml($description)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid description of the image'
				]);
			}

			$image->description = $description;
		}
		
		$ok = $image->save();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to update image'
			]);
		}
		
		return $api->response([
			'success' => true,
			'message' => 'Image was updated',
			'image' => [
				'image_id' => $image->id,
				'name' => $image->name,
				'description' => $image->description,
				'image' => $image->image,
				'size' => $image->size,
				'extension' => $image->extension,
				'width' => $image->width,
				'height' => $image->height,
			]
		]);
		
	}

	public function uploadImage( $imageId ) {
		$api = $this->api;

		$image = new ImageObject( (int) $imageId );

		//Comprobamos que no este vacio nuestro input file.
		if (file_exists($_FILES['file-input']['tmp_name'])) {
			//obtenemos el ancho y alto de la imagen
			$fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
			$width = $fileinfo[0];
			$height = $fileinfo[1];
			//extensiones admitidas
			$allowed_image_extension = array("png", "jpg", "jpeg");
			// Get image file extension
			$file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);

			// Validate file input to check if is with valid extension
			if (!in_array($file_extension, $allowed_image_extension)) {
				return $api->response([
					'success' => false,
					"message" => "Subir imagenes validas, solo se permite png, jpg y jpeg."
				]);
			}
			// Validate image file dimension
			if ($width > "1800" || $height > "1200") {
				return $api->response([
					'success' => false,
					"message" => "La dimensión de la imagen debe estar dentro de 1800X1200."
				]);
			}

			$imageCOD = base64_encode(file_get_contents($_FILES['file-input']['tmp_name']));

			$image->image = $imageCOD;
			$image->size = (string) $_FILES['file-input']['size'];
			$image->extension = $file_extension;
			$image->width = (string) $width;
			$image->height = (string) $height;
		}

		$ok = $image->save();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to update image'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Imagen subida con exito',
			'image' => [
				'image_id' => $image->id,
				'name' => $image->name,
				'description' => $image->description,
				'image' => $image->image,
				'size' => $image->size,
				'extension' => $image->extension,
				'width' => $image->width,
				'height' => $image->height,
			]
		]);
	}
	
	public function deleteImage( $imageId ) {
		$api = $this->api;

		$image = new ImageObject( (int) $imageId );
		if(!Validate::isLoadedObject($image)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Image was not found'
			]);
		}

		$ok = $image->delete();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to delete image'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Image deleted successfully'
		]);
	}
	
	public function searchImages() {
		$api = $this->api;
		$params = $api->request()->get(); 

		$name = ArrayUtils::get($params, 'name');

		if(!$name) {
			return $api->response([
				'success' => false,
				'message' => 'Enter name of the image'
			]);
		}

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('image.*');
		// Build FROM
		$sql->from('image', 'image');

		// prevent sql from searching a NULL value if wither name is not provided eg. WHERE name = null
		$where_clause = array();
		if($name) {
			$where_clause[] = 'image.name LIKE \'%' . pSQL($name) . '%\'';
		}
		
		// join the search terms
		$where_clause = implode(' OR ', $where_clause);

		// Build WHERE
		$sql->where($where_clause);
		
		$images = Db::getInstance()->executeS($sql);
		
		if(! $images) {
			return $api->response([
				'success' => false,
				'message' => 'No hay imagenes que coincidan con esta busqueda'
			]);
		}
		
		return $api->response([
			'success' => true,
			'images' => $images
		]);
    }
    
}


