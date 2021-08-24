<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;

class TypeNumber extends Rule {
	/** @var string[] */
	protected array $attributes = [
		"type=number",
		"type=range",
	];

	public function isValid(Element $element, string $value):bool {
		$min = $element->getAttribute("min") ?: null;
		$max = $element->getAttribute("max") ?: null;
		$step = $element->getAttribute("step") ?: null;

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
