<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;
use Gt\Dom\ElementType;

class TypeRadio extends Rule {
	public function isValid(Element $element, string $value):bool {
		if($element->elementType !== ElementType::HTMLInputElement) {
			return true;
		}
		if($element->type !== "radio") {
			return true;
		}

		if($value === "") {
			return true;
		}

		if(!$element->form) {
			return true;
		}

		$availableValues = [];
		$name = $element->name;
		foreach($element->form->querySelectorAll("[name='$name']") as $siblingInput) {
			if($radioValue = $siblingInput->value) {
				array_push($availableValues, $radioValue);
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
