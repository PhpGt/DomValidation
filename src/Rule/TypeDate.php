<?php
namespace Gt\DomValidation\Rule;

use DateTime;
use DOMElement;

class TypeDate extends Rule {
// ISO-8601 derived date formats:
	const FORMAT_DATE = "Y-m-d";

	protected $attributes = [
		"type=date",
	];

	public function isValid(DOMElement $element, string $value):bool {
		if($value === "") {
			return true;
		}

		$dateTime = DateTime::createFromFormat(
			self::FORMAT_DATE,
			$value
		);
		return $dateTime !== false;
	}

	public function getHint(DOMElement $element, string $value):string {
		return "Field must be a date in the format YYYY-mm-dd";
	}
}