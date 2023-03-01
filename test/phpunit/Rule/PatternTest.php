<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\Dom\HTMLDocument;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class PatternTest extends TestCase {
	public function testPattern() {
		$document = new HTMLDocument(Helper::HTML_PATTERN_CREDIT_CARD);
		$form = $document->forms[0];
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
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testPatternInvalid() {
		$document = new HTMLDocument(Helper::HTML_PATTERN_CREDIT_CARD);
		$form = $document->forms[0];
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
		$document = new HTMLDocument(Helper::HTML_PATTERN_CREDIT_CARD_ALL_REQUIRED_FIELDS);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(3, $errorArray);
			$expiryMonthErrorArray = $errorArray["expiry-month"];
			$expiryYearErrorArray = $errorArray["expiry-year"];
			$amountErrorArray = $errorArray["amount"];
			self::assertCount(1, $expiryMonthErrorArray);
			self::assertCount(1, $expiryYearErrorArray);
			self::assertCount(1, $amountErrorArray);
			self::assertEquals($expiryMonthErrorArray[0], "This field is required");
			self::assertEquals($expiryYearErrorArray[0], "This field is required");
			self::assertEquals($amountErrorArray[0], "This field is required");
		}
	}

	public function testPatternTitleShown() {
		$document = new HTMLDocument(Helper::HTML_PATTERN_CREDIT_CARD_ALL_REQUIRED_FIELDS);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"name" => "Elon Musk",
				"creit-card" => "420420"
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertContains(
				"This field does not match the required pattern: The 16 digit number on the front of your card",
				$errorArray["credit-card"]
			);
		}
	}
}
