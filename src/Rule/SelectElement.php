<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class SelectElement extends Rule {
	public function isValid(DOMElement $element, string $value):bool {
		$availableValues = [];

		if($element->tagName !== "select") {
			return true;
		}

		if($value === "") {
			return true;
		}

		$optionElementList = $element->getElementsByTagName("option");
		for($i = 0, $len = $optionElementList->length; $i < $len; $i++) {
			$option = $optionElementList->item($i);

			if($option->hasAttribute("value")) {
				$optionValue = $option->getAttribute("value");
			}
			else {
				$optionValue = $option->nodeValue;
			}

			if($optionValue !== "") {
				$availableValues []= $optionValue;
			}
		}

		if(!in_array($value, $availableValues)) {
			return false;
		}

		return true;
	}

	public function getHint(DOMElement $element, string $value):string {
		return "This field's value must match one of the available options";
	}
}