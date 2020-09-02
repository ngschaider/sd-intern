<?php
/**
 * @author Niklas Gschaider <niklas.gschaider@gschaider-systems.at>
 */


namespace app\components;


use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Nav extends \yii\bootstrap4\Nav {


	/**
	 * {@inheritDoc}
	 */
	public function renderItem($item) {
		if(is_string($item)) {
			return $item;
		}
		if(!isset($item['label'])) {
			throw new InvalidConfigException("The 'label' option is required.");
		}
		$encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
		$label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
		$options = ArrayHelper::getValue($item, 'options', []);
		$items = ArrayHelper::getValue($item, 'items');
		$url = ArrayHelper::getValue($item, 'url', '#');
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
		$disabled = ArrayHelper::getValue($item, 'disabled', false);
		$active = $this->isItemActive($item);

		$adminOnly = ArrayHelper::getValue($item, "adminOnly", false);
		if($adminOnly && (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin)) {
			return "";
		}

		if(empty($items)) {
			$items = '';
		} else {
			$linkOptions['data-toggle'] = 'dropdown';
			Html::addCssClass($options, ['widget' => 'dropdown']);
			Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
			if(is_array($items)) {
				$items = $this->isChildActive($items, $active);
				$items = $this->renderDropdown($items, $item);
			}
		}

		Html::addCssClass($options, 'nav-item');
		Html::addCssClass($linkOptions, 'nav-link');

		if($disabled) {
			ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
			ArrayHelper::setValue($linkOptions, 'aria-disabled', 'true');
			Html::addCssClass($linkOptions, 'disabled');
		} else if($this->activateItems && $active) {
			Html::addCssClass($linkOptions, 'active');
		}

		return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
	}

}