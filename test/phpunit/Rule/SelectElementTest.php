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
				"connections" => "native",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$currencyErrorArray = $errorArray["currency"];
			self::assertContains(
				"This field is required",
				$currencyErrorArray
			);
		}
	}
}