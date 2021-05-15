<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\models;


use app\components\ActiveRecord;
use Symfony\Component\DomCrawler\Form;

/**
 *
 * @property-read integer $id
 *
 * @property-read Formation $formation
 * @property-read FramePosition[] $framePositions
 */
class Frame extends ActiveRecord {

	public function rules() {
		return [
			[["name"], "required"],
			[["name"], "string", "max" => 255],
			[["formationId"], "exist", "targetClass" => Formation::class, "targetAttribute" => "id"],
		];
	}

	public function getFormation() {
		return $this->hasOne(Formation::class, ["id" => "formationId"]);
	}

	public function getFramePositions() {
		return $this->hasMany(FramePosition::class, ["frameId" => "id"]);
	}

}