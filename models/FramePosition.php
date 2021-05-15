<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;


use app\components\ActiveRecord;

/**
 * Class FramePosition
 *
 * @package app\models
 * @property-read integer $id
 * @property integer $frameId
 */
class FramePosition extends ActiveRecord {

	public function rules() {
		return [
			[["number"], "integer", "min" => 0, "max" => "99"],
			[["x", "y"], "number", "min" => -1, "max" => 1],
			[["color"], "string"],
			[["rotation"], "number"],
		];
	}

}