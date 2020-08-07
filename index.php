<?php 
/**
 * @package    PHP Advanced API Guide
 * @author     Bermudez Steven
 * @copyright  2019 Bermudez
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

 // Namespaces
define('API_NAMESPACE',          'BestShop');
define('API_DIR_ROOT',            dirname(__FILE__));
define('API_DIR_CLASSES',         API_DIR_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
define('API_DIR_CONTROLLERS',     API_DIR_ROOT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR);

require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'functions.php'; 

use BestShop\Api;
use BestShop\Database\DbQuery;
use BestShop\Database\DbCore;
use BestShop\Database\DbPDOCore;
use BestShop\Database\DbMySQLiCore;

abstract class Db extends DbCore {};
class DbPDO extends DbPDOCore {};
class DbMySQLi extends DbMySQLiCore {};

/** CORS Middleware */
$config = array(
	/** MySQL database name */
	'database_name' => 'rest_api',
	/** MySQL hostname */
	'database_host' => 'localhost',
	/** MySQL database username */
	'database_user' => 'root',
	/** MySQL database password */ 
	'database_password' => '',
	/** MySQL Database Table prefix. */
	'database_prefix' => '',
	/** preferred database */
	'database_engine' => 'DbPDO',
	/** API CORS */
	'cors' => [
		'enabled' => true,
		'origin' => '*', // can be a comma separated value or array of hosts
		'headers' => [
			'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Authorization, Cache-Control, Content-Type, Access-Control-Allow-Origin',
			'Access-Control-Allow-Credentials' => 'true',
			'Access-Control-Allow-Methods' => 'GET,PUT,POST,DELETE,OPTIONS,PATCH'
		]
	]
);

define('_DB_SERVER_', $config['database_host']);
define('_DB_NAME_', $config['database_name']);

define('_DB_USER_', $config['database_user']);
define('_DB_PASSWD_', $config['database_password']);
define('_DB_PREFIX_',  $config['database_prefix']);
define('_MYSQL_ENGINE_',  $config['database_engine']);

/** API Construct */
$api = new Api([
	'mode' => 'development',
    'debug' => true
]);

$api->add(new \BestShop\Slim\CorsMiddleware());
$api->config('debug', true);

/**
 * Request Payload
 */
$params = $api->request->get();
$requestPayload = $api->request->post();

$api->group('/api', function () use ($api) {
	$api->group('/v1', function () use ($api) {
		/** Get all Images */
		$api->get('/images?', '\BestShop\v1\Image:getImages')->name('get_images');
		/** Add a Image */
		$api->post('/images?', '\BestShop\v1\Image:addImage')->name('add_images');
		/** upload a Image */
		$api->post('/upload-image/:imageId?', '\BestShop\v1\Image:uploadImage')->name('upload_images');

		/** Get a single Image */
		$api->get('/images/:imageId?', '\BestShop\v1\Image:getImage')->name('add_image');
		/** Update a single Image */
		$api->patch('/images/:imageId?', '\BestShop\v1\Image:updateImage')->name('update_image');
		/** Delete a single Image */
		$api->delete('/images/:imageId?', '\BestShop\v1\Image:deleteImage')->name('delete_image');
		/** search Images */
		$api->get('/search?', '\BestShop\v1\Image:searchImages')->name('search_images');

		/** Grouping Album Endpoints */
		$api->group('/albums', function () use ($api) {
			/** Get all Albums */
			$api->get('/?', '\BestShop\v1\Album:getAlbums')->name('get_albums');
			
			/** Add a Album */
			$api->post('/?', '\BestShop\v1\Album:addAlbum')->name('add_album');
	
		});
	});
});

$api->notFound(function () use ($api) {
	$api->response([
		'success' => false,
		'error' => 'Resource Not Found'
	]);
	return $api->stop();
});

$api->response()->header('Content-Type', 'application/json; charset=utf-8');
$api->run();
