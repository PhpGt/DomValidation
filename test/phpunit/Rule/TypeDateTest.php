<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class TypeDateTest extends DomValidationTestCase {
	public function testTypeDate() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"dob" => "1968-11-22",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testTypeDateInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"dob" => "November 22nd 1968",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$dobErrorArray = $errorArray["dob"];
			self::assertContains(
				"Field must be a date in the format YYYY-mm-dd",
				$dobErrorArray
			);
		}
	}
}