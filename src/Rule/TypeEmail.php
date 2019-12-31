<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class TypeEmail extends Rule {
	protected $attributes = [
		"type=email",
	];

	public function isValid(DOMElement $element, string $value):bool {
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}

	public function getHint(DOMElement $element, string $value):string {
		return "Field must be an email address";
	}
}