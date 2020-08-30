<?php

namespace app\components;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn {

	public $customButtons;

	/**
	 * Initializes the default button rendering callbacks.
	 */
	protected function initDefaultButtons() {
		$this->initDefaultButton('view', UTF8::EYE);
		$this->initDefaultButton('update', UTF8::LOWER_LEFT_PENCIL);
		$this->initDefaultButton('delete', UTF8::WASTEBASKET, [
			'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
			'data-method' => 'post',
		]);
	}

	/**
	 * Initializes the default button rendering callback for single button.
	 *
	 * @param string $name Button name as it's written in template
	 * @param string $icon The icon (UTF-8)
	 * @param array $additionalOptions Array of additional options
	 * @since 2.0.11
	 */
	protected function initDefaultButton($name, $icon, $additionalOptions = []) {
		if(!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
			$this->buttons[$name] = function($url, $model, $key) use ($name, $icon, $additionalOptions) {
				switch($name) {
					case 'view':
						$title = Yii::t('yii', 'View');
						break;
					case 'update':
						$title = Yii::t('yii', 'Update');
						break;
					case 'delete':
						$title = Yii::t('yii', 'Delete');
						break;
					default:
						$title = ucfirst($name);
				}
				$options = array_merge([
					'title' => $title,
					'aria-label' => $title,
					'data-pjax' => '0',
				], $additionalOptions, $this->buttonOptions);

				$icon = Html::tag('span', $icon);

				return Html::a($icon, $url, $options);
			};
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function renderDataCellContent($model, $key, $index) {
		return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function($matches) use ($model, $key, $index) {
			$name = $matches[1];

			if(isset($this->visibleButtons[$name])) {
				$isVisible = $this->visibleButtons[$name] instanceof \Closure
					? call_user_func($this->visibleButtons[$name], $model, $key, $index)
					: $this->visibleButtons[$name];
			} else {
				$isVisible = true;
			}

			if($isVisible && isset($this->buttons[$name])) {
				$url = $this->createUrl($name, $model, $key, $index);

				return call_user_func($this->buttons[$name], $url, $model, $key);
			}

			if($isVisible && isset($this->customButtons[$name])) {
				$url = $this->createUrl($name, $model, $key, $index);

				return call_user_func($this->customButtons[$name], $url, $model, $key);
			}

			return '';
		}, $this->template);
	}

}