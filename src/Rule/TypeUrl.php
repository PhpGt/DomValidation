<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class TypeUrl extends Rule {
	protected $attributes = [
		"type=url",
	];

	public function isValid(DOMElement $element, string $value):bool {
		return $value === ""
		|| filter_var($value, FILTER_VALIDATE_URL) !== false;
	}

	public function getHint(DOMElement $element, string $value):string {
		return "Field must be a URL";
	}
}