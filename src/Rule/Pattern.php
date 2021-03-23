<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

class Pattern extends Rule {
	protected array $attributes = [
		"pattern",
	];

	public function isValid(DOMElement $element, string $value):bool {
		$pattern = "/" . $element->getAttribute("pattern") . "/";
		return preg_match($pattern, $value);
	}

	public function getHint(DOMElement $element, string $value):string {
		$hint = "This field does not match the required pattern";

		if($title = $element->getAttribute("title")) {
			$hint .= ": $title";
		}

		return $hint;
	}
}
