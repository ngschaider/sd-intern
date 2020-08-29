<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\components;


use yii\web\HttpException;

class ModelNotFoundException extends HttpException {

	public function __construct($code = 0, \Exception $previous = null) {
		parent::__construct(404, "The requested item could not be found.", $code, $previous);
	}

}