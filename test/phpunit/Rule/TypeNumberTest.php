<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class TypeNumberTest extends DomValidationTestCase {
	public function testNumberFieldEmpty() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-month" => "",
				"expiry-year" => "",
				"amount" => "",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testNumberField() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-month" => "01",
				"expiry-year" => "22",
				"amount" => "100",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testNumberFieldFloat() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-month" => "01",
// contrary to this making sense, it is actually valid without a "step":
				"expiry-year" => "22.345",
				"amount" => "100",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testNumberFieldNotANumber() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-month" => "January",
				"expiry-year" => "22",
				"amount" => "100",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);

		}
	}
}