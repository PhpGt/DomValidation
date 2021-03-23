<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class RequiredTest extends DomValidationTestCase {
	public function testSimpleMissingRequiredInput() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		self::expectException(ValidationException::class);
		self::expectExceptionMessage("There is 1 invalid field");

		$validator->validate($form, [
			"username" => "g105b",
		]);
	}

	public function testSimpleMissingBothRequiredInputs() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		self::expectException(ValidationException::class);
		self::expectExceptionMessage("There are 2 invalid fields");

		$validator->validate($form, ["something" => "nothing"]);
	}

	public function testSimpleMissingRequiredInputErrorList() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		try {
			$validator->validate($form, ["username" => "g105b"]);
		}
		catch(ValidationException $exception) {
			foreach($validator->getLastErrorList() as $name => $errors) {
				self::assertIsArray($errors);
				self::assertContains("This field is required", $errors);
			}
		}
	}

	public function testSimpleEmptyRequiredInputErrorList() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"username" => "g105b",
				"password" => ""
			]);
		}
		catch(ValidationException $exception) {
			foreach($validator->getLastErrorList() as $name => $errors) {
				self::assertIsArray($errors);
				self::assertContains("This field is required", $errors);
				self::assertEquals("password", $name);
			}
		}
	}

	public function testNumberFieldRequiredButEmpty() {
		$form = self::getFormFromHtml(Helper::HTML_PATTERN_CREDIT_CARD_ALL_REQUIRED_FIELDS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"name" => "Jeff Bezos",
				"credit-card" => "4921166184521652",
				"expiry-month" => "",
				"expiry-year" => "",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(3, $errorArray);
		}
	}
}
