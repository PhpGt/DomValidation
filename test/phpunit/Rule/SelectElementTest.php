<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class SelectElementTest extends DomValidationTestCase {
	public function testSelect() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "GBP",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testSelectMissingRequired() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"currency" => "",
			]);
		}
		catch(ValidationException) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$currencyErrorArray = $errorArray["currency"];
			self::assertContains(
				"This field is required",
				$currencyErrorArray
			);
		}
	}

	public function testSelectTextContent() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"sort" => "Descending",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testSelectTextContentInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"sort" => "Random", // This <option> does not exist
			]);
		}
		catch(ValidationException) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$currencyErrorArray = $errorArray["sort"];
			self::assertContains(
				"This field's value must match one of the available options",
				$currencyErrorArray
			);
		}
	}

	public function testSelectValue_textContent() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"connections" => "All", // This is invalid
// There is an <option> with "All" as its text content, but not with this value.
			]);
		}
		catch(ValidationException $exception) {}

		self::assertSame("There is 1 invalid field", $exception->getMessage());
	}

	public function testSelectValue_invalid() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"connections" => "Unknown", // This is invalid
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$currencyErrorArray = $errorArray["connections"];
			self::assertContains(
				"This field's value must match one of the available options",
				$currencyErrorArray
			);
		}
	}

	public function testSelectTwoInvalidOptionsAndOneMissing() {
		$form = self::getFormFromHtml(Helper::HTML_SELECT);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"connections" => "none",
				"sort" => "random",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(3, $errorArray);
			$currencyErrorArray = $errorArray["currency"];
			$sortErrorArray = $errorArray["sort"];
			$connectionsErrorArray = $errorArray["connections"];
			self::assertContains(
				"This field is required",
				$currencyErrorArray
			);
			self::assertContains(
				"This field's value must match one of the available options",
				$sortErrorArray
			);
			self::assertContains(
				"This field's value must match one of the available options",
				$connectionsErrorArray
			);
		}
	}
}
