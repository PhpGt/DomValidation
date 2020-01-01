<?php
namespace Gt\DomValidation\Rule;

use DateTime;
use DOMElement;

class TypeDate extends Rule {
// ISO-8601 derived date formats:
	const FORMAT_DATE = "Y-m-d";
	const FORMAT_MONTH = "Y-m";
	const FORMAT_WEEK = "Y-\WW";
	const FORMAT_DATETIME_LOCAL = "Y-m-d\TH:i";
	const FORMAT_TIME = "H:i";

	protected $attributes = [
		"type=date",
		"type=month",
		"type=week",
		"type=datetime-local",
		"type=time",
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
			$success = preg_match(
				"/^(?P<year>\d{4})-W(?P<week>\d{1,2})$/",
				$value,
				$matches
			);
			if(!$success) {
				return false;
			}

			if($matches["week"] < 1 || $matches["week"] > 52) {
				return false;
			}

			$dateTime = new DateTime();
			$dateTime->setISODate($matches["year"], $matches["week"]);

			break;

		case "datetime-local":
			$dateTime = DateTime::createFromFormat(
				self::FORMAT_DATETIME_LOCAL,
				$value
			);
			break;

		case "time":
			$dateTime = DateTime::createFromFormat(
				self::FORMAT_TIME,
				$value
			);
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

		case "datetime-local":
			$format = self::FORMAT_DATETIME_LOCAL;
			break;

		case "time":
			$format = self::FORMAT_TIME;
			break;
		}

		return "Field must be a $type in the format $format";
	}
}