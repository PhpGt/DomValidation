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
			$expiryMonthError = $errorArray["expiry-month"];
			self::assertContains(
				"Field must be a number",
				$expiryMonthError
			);
		}
	}

	public function testStep() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"step1" => "14",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testStepInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"step1" => "15",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$step1Error = $errorArray["step1"];
			self::assertContains(
				"Field value must be a multiple of 7",
				$step1Error
			);
		}
	}

	public function testStepNegative() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"step1" => "-21",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testStepStartingFrom2() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"step2" => "16",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testStepStartingFrom2Invalid() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"step2" => "21",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$step1Error = $errorArray["step2"];
			self::assertContains(
				"Field value must be 2 plus a multiple of 7",
				$step1Error
			);
		}
	}

	public function testStepWithMax() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"step3" => 7.2 * 3, // within range
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testStepWithMaxBust() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"step3" => 7.2 * 4, // out of range
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$step1Error = $errorArray["step3"];
			self::assertContains(
				"Field value must not be greater than 25.1",
				$step1Error
			);
		}
	}

	public function testStepWithDecimalStart() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"step4" => 3.5 + (7.2 * 2),
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testStepWithDecimalStartBust() {
		$form = self::getFormFromHtml(Helper::HTML_STEP_NUMBERS);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"step4" => 3.5 + (7.2 * 4),
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$step1Error = $errorArray["step4"];
			self::assertContains(
				"Field value must not be greater than 25.1",
				$step1Error
			);
		}
	}
}