<?php 

namespace BestShop\Image;

use Db;
use BestShop\Database\DbQuery;
use BestShop\ObjectModel;

class Image extends ObjectModel {
	/** @var $id Image ID */
	public $id;
    
    /** @var int $album_id */
    public $album_id;
    
	/** @var string $name */
    public $name;
    
    /** @var string $description */
	public $description;

    /** @var string $image */
    public $image;
    
	/** @var string $size */
	public $size;
	
	/** @var string $extension */
    public $extension;
    
    /** @var string $width */
    public $width;

    /** @var string $height */
    public $height;
    	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'image',
        'primary' => 'image_id',
        'fields' => array(
            'album_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
            'name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 32),
            'description' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 200),
			'image' => array('type' => self::TYPE_NOTHING, 'required' => true),
			'size' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 32),
            'extension' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 32),
            'width' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 32),
            'height' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 32),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

     /**
     * constructor.
     *
     * @param null $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
	}
}