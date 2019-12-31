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

	public function getHint(DOMElement $element, string $value):string {
		return "This field is required";
	}
}