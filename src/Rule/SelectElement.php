<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;
use Gt\Dom\HTMLElement\HTMLOptionElement;
use Gt\Dom\HTMLElement\HTMLSelectElement;

class SelectElement extends Rule {
	public function isValid(Element $element, string $value):bool {
		$availableValues = [];

		if(!$element instanceof HTMLSelectElement) {
			return true;
		}
		/** @var HTMLSelectElement $element */

		if($value === "") {
			return true;
		}

		foreach($element->options as $option) {
			if($optionValue = $option->value) {
				array_push($availableValues, $optionValue);
			}
		}

		if(!in_array($value, $availableValues)) {
			return false;
		}

		return true;
	}

	public function getHint(Element $element, string $value):string {
		return "This field's value must match one of the available options";
	}
}
