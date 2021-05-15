<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\components;

class GridView extends \yii\grid\GridView {

	public function run() {
		echo "<div class='table-responsive'>";
		parent::run();
		echo "</div>";
	}

}