<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class PatternTest extends DomValidationTestCase {
	public function testPattern() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-year" => 20,
				"expiry-month" => 12,
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testPatternInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "492116611652", // not enough numbers
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$creditCardErrorArray = $errorArray["credit-card"];
			self::assertCount(1, $creditCardErrorArray);
			self::assertEquals(
				"This field does not match the required pattern",
				$creditCardErrorArray[0]
			);
		}
	}

	public function testPatternWithMissingRequiredFields() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD_ALL_REQUIRED_FIELDS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(2, $errorArray);
			$expiryMonthErrorArray = $errorArray["expiry-month"];
			$expiryYearErrorArray = $errorArray["expiry-year"];
			self::assertCount(1, $expiryMonthErrorArray);
			self::assertCount(1, $expiryYearErrorArray);
			self::assertEquals($expiryMonthErrorArray[0], "This field is required");
			self::assertEquals($expiryYearErrorArray[0], "This field is required");
		}
	}
}