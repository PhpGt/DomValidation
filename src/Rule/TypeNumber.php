<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class TypeNumber extends Rule {
	/** @var string[] */
	protected array $attributes = [
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
		$min = $element->getAttribute("min") ?: null;
		$max = $element->getAttribute("max") ?: null;
		$step = $element->getAttribute("step") ?: null;
		$hint = "";

		if(is_numeric($value)) {
			$value = (float)$value;

			if(!is_null($min)
			&& $value < $min) {
				$hint = "Field value must not be less than $min";
			}
			elseif(!is_null($max)
			&& $value > $max) {
				$hint = "Field value must not be greater than $max";
			}
			elseif(!is_null($step)) {
				if(!is_null($min)
				&& ($value - $min) % $step !== 0) {
					$hint = "Field value must be $min plus a multiple of $step";
				}
				elseif($value % $step !== 0) {
					$hint = "Field value must be a multiple of $step";
				}
			}
		}
		else {
			$hint = "Field must be a number";
		}

		return $hint;
	}
}
