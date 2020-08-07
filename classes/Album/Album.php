<?php 

namespace BestShop\Album;

use Db;
use BestShop\Database\DbQuery;
use BestShop\ObjectModel;

class Album extends ObjectModel {
	/** @var $id Album ID */
	public $id;

	/** @var string $name */
	public $name;

	/** @var string $description */
	public $description;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'album',
        'primary' => 'album_id',
        'fields' => array(
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
			'description' => array('type' => self::TYPE_STRING),
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