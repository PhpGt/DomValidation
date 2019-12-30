<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class Required extends Rule {
	protected $attributes = [
		"required",
	];

	public function isValid(DOMElement $element, string $value):bool {
		return !empty($value);
	}

	public function getErrorMessage(string $name):string {
		return "This field is required";
	}
}