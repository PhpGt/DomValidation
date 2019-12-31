<?php
namespace Gt\DomValidation\Rule;

use DateTime;
use DOMElement;

class TypeDate extends Rule {
// ISO-8601 derived date formats:
	const FORMAT_DATE = "Y-m-d";
	const FORMAT_MONTH = "Y-m";
	const FORMAT_WEEK = "Y-\WW";

	protected $attributes = [
		"type=date",
		"type=month",
		"type=week",
	];

	public function isValid(DOMElement $element, string $value):bool {
		if($value === "") {
			return true;
		}

		$dateTime = null;

		switch($element->getAttribute("type")) {
		case "date":
			$dateTime = DateTime::createFromFormat(
				self::FORMAT_DATE,
				$value
			);
			break;

		case "month":
			$dateTime = DateTime::createFromFormat(
				self::FORMAT_MONTH,
				$value
			);
			break;

		case "week":
			if(strstr($value, "-W")) {
				list($year, $week) = explode("-", $value);
			}
			else {
				return false;
			}

			$week = ltrim($week, "W");

			$dateTime = new DateTime();
			$dateTime->setISODate($year, $week);

			if(!is_numeric($week)
			|| $week < 1 || $week > 52) {
				return false;
			}

			break;
		}

		return $dateTime !== false;
	}

	public function getHint(DOMElement $element, string $value):string {
		$format = null;
		$type = $element->getAttribute("type");

		switch($type) {
		case "date":
			$format = self::FORMAT_DATE;
			break;

		case "month":
			$format = self::FORMAT_MONTH;
			break;

		case "week":
			$format = self::FORMAT_WEEK;
			break;
		}

		return "Field must be a $type in the format $format";
	}
}