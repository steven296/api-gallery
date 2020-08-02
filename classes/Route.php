<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Bermudez Steven
 * @copyright  2019 Bermudez
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace BestShop;

use BestShop\Api;

abstract class Route
{
    /**
     * @var \Slim\Slim
     */
    protected $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }
}
