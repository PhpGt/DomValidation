<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class TypeNumber extends Rule {
	protected $attributes = [
		"type=number",
		"type=range",
	];

	public function isValid(DOMElement $element, string $value):bool {
		$min = $element->getAttribute("min") ?? null;
		$max = $element->getAttribute("max") ?? null;
		$step = $element->getAttribute("step") ?? null;

		if(empty($value)) {
			return true;
		}

		if(!is_numeric($value)) {
			return false;
		}

		if($min !== ""
		&& $value < $min) {
			return false;
		}

		if($max !== ""
		&& $value > $max) {
			return false;
		}

		if($step !== "") {
			if($min) {
				return ($value - $min) % $step === 0;
			}

			return $value % $step === 0;
		}

		return true;
	}

	public function getHint(DOMElement $element, string $value):string {
		$min = $element->getAttribute("min") ?? null;
		$max = $element->getAttribute("max") ?? null;
		$step = $element->getAttribute("step") ?? null;

		if(!is_numeric($value)) {
			return "Field must be a number";
		}

		if($min !== ""
		&& $value < $min) {
			return "Field value must not be less than $min";
		}

		if($max !== ""
		&& $value > $max) {
			return "Field value must not be greater than $max";
		}

		if(!empty($step)) {
			if($min
			&& ($value - $min) % $step !== 0) {
				return "Field value must be $min plus a multiple of $step";
			}

			if($value % $step !== 0) {
				return "Field value must be a multiple of $step";
			}
		}
	}
}