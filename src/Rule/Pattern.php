<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class Pattern extends Rule {
	protected $attributes = [
		"pattern",
	];

	public function isValid(DOMElement $element, string $value):bool {
		$pattern = "/" . $element->getAttribute("pattern") . "/";
		return preg_match($pattern, $value);
	}

	public function getErrorMessage(string $name):string {
		return "This field does not match the required pattern";
	}
}