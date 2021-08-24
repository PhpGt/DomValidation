<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class RadioElementTest extends DomValidationTestCase {
	public function testRadio() {
		$form = self::getFormFromHtml(Helper::HTML_RADIO);
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

	public function testRadioMissingRequired() {
		$form = self::getFormFromHtml(Helper::HTML_RADIO);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"sort" => "asc",
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

	public function testRadioTextContent() {
		$form = self::getFormFromHtml(Helper::HTML_RADIO);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"sort" => "desc",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}
}
