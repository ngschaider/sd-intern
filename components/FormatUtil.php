<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */

namespace app\components;

final class FormatUtil {

	public static function formatPercentage($percentage) {
		return round($percentage * 100, 2);
	}

}