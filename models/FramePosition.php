<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;


use app\components\ActiveRecord;

class FramePosition extends ActiveRecord {

	public function rules() {
		return [
			[["number"], "integer", "min" => 0, "max" => "99"],
			[["x", "y"], "number", "min" => -1, "max" => 1],
			[["rotation"], "number"],
		];
	}

}