<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class MinLength extends Rule {
	protected array $attributes = [
		"minlength"
	];

	public function isValid(DOMElement $element, string $value):bool {
		$minLength = $element->getAttribute("minlength");
		return strlen($value) >= $minLength;
	}

	public function getHint(DOMElement $element, string $value):string {
		$minLength = $element->getAttribute("minlength");
		return "This field's value must contain at least $minLength characters";
	}
}
