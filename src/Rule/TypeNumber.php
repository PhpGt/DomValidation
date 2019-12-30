<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class TypeNumber extends Rule {
	protected $attributes = [
		"type=number",
	];

	public function isValid(DOMElement $element, string $value):bool {
		return is_numeric($value);
	}

	public function getErrorMessage(string $name):string {
		return "Field must be a number";
	}
}