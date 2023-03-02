<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;

class TypeNumber extends Rule {
	/** @var string[] */
	protected array $attributes = [
		"type=number",
		"type=range",
	];

	public function isValid(
		Element $element,
		string $value,
		array $inputKvp,
	):bool {
		if($value === "") {
			return true;
		}

		if(is_numeric($value)) {
			$value = (float)$value;

			if(false === $this->isValidMin(
				(float)$element->getAttribute("min"),
				$value,
			)) {
				return false;
			}
			if(false === $this->isValidMax(
				(float)$element->getAttribute("max"),
				$value,
			)) {
				return false;
			}
			if(false === $this->isValidStep(
				(float)$element->getAttribute("min"),
				(float)$element->getAttribute("step"),
				$value,
			)) {
				return false;
			}
		}

		return true;
	}

	public function getHint(Element $element, string $value):string {
		if(!is_numeric($value)) {
			return "Field must be a number";
		}

		$value = (float)$value;

		if($message = $this->getHintMinMax(
			$value,
			(float)$element->getAttribute("min"),
			(float)$element->getAttribute("max"),
		)) {
			return $message;
		}

		if($message = $this->getHintStep(
			$value,
			(float)$element->getAttribute("min"),
			(float)$element->getAttribute("step"),
		)) {
			return $message;
		}

		return "";
	}

	private function getHintMinMax(
		float $value,
		?float $min,
		?float $max,
	):?string {
		if(!is_null($min)) {
			if($value < $min) {
				return "Field must not be less than $min";
			}
		}
		if(!is_null($max)) {
			if($value > $max) {
				return "Field must not be more than $max";
			}
		}

		return null;
	}

	private function getHintStep(
		float $value,
		?float $min,
		?float $step,
	):?string {
		if(!is_null($min)) {
			if(($value - $min) % $step !== 0) {
				return "Field value must be $min plus a multiple of $step";
			}
		}

		if($value % $step !== 0) {
			return "Field value must be a multiple of $step";
		}

		return null;
	}

	private function isValidMin(?float $min, float $value):bool {
		if(is_null($min)) {
			return true;
		}

		return $value >= $min;
	}

	private function isValidMax(?float $max, float $value):bool {
		if(is_null($max)) {
			return true;
		}

		return $value <= $max;
	}

	private function isValidStep(?float $min, ?float $step, float $value):bool {
		if(is_null($step)) {
			return true;
		}
		if(is_null($min)) {
			return $value % $step === 0;
		}

		return ($value - $min) % $step === 0;
	}
}
