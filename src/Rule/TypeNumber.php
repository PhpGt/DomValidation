<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;

class TypeNumber extends Rule {
	/** @var string[] */
	protected array $attributes = [
		"type=number",
		"type=range",
	];

	public function isValid(Element $element, string $value, array $inputKvp):bool {
		if($min = $element->getAttribute("min") ?: null) {
			$min = (float)$min;
		}
		if($max = $element->getAttribute("max") ?: null) {
			$max = (float)$max;
		}
		if($step = $element->getAttribute("step") ?: null) {
			$step = (float)$step;
		}

		if($value === "") {
			$validity = true;
		}
		elseif(is_numeric($value)) {
			$value = (float)$value;

			if(!is_null($min)
			&& $value < $min) {
				$validity = false;
			}
			elseif(!is_null($max)
			&& $value > $max) {
				$validity = false;
			}
			elseif(!is_null($step)) {
				if($min) {
					$validity = ($value - $min) % $step === 0;
				}
				else {
					$validity = $value % $step === 0;
				}

			}
			else {
				$validity = true;
			}
		}
		else {
			$validity = false;
		}

		return $validity;
	}

	public function getHint(Element $element, string $value):string {
		if($min = $element->getAttribute("min") ?: null) {
			$min = (float)$min;
		}
		if($max = $element->getAttribute("max") ?: null) {
			$max = (float)$max;
		}
		if($step = $element->getAttribute("step") ?: null) {
			$step = (float)$step;
		}
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
