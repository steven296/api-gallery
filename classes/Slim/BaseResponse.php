<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Bermudez Steven
 * @copyright  2019 Bermudez
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace BestShop\Slim;

use Slim\Http\Response;

class BaseResponse extends Response {
    public function withHeaders(array $headers) {
        foreach($headers as $name => $value) {
            $this->headers->set($name, $value);
        }

        return $this;
    }

    public function setHeader($name, $value) {
        return $this->withHeaders([$name => $value]);
    }
}
