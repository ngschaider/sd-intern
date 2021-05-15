<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\models;

use app\components\ActiveRecord;

/**
 * Class Location
 *
 * @package app\models
 *
 * @property-read integer $id
 * @property string $name
 */
class Location extends ActiveRecord {

	public function rules() {
		return [
			[["name"], "required"],
			[["name"], "string", "max" => 255],
		];
	}

}