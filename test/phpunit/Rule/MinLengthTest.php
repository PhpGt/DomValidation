<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class MinLengthTest extends DomValidationTestCase {
	public function testMinLengthOK() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		$exception = null;
		try {
			$validator->validate($form, [
				"username" => "mikebrewer",
				"password" => "holdoutyerhand1964",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testMinLength() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		$exception = null;
		try {
			$validator->validate($form, [
				"username" => "mikebrewer",
				"password" => "mb1964",
			]);
		}
		catch(ValidationException $exception) {
			$errorList = iterator_to_array($validator->getLastErrorList());
			self::assertContains(
				"This field's value must contain at least 12 characters",
				$errorList["password"]
			);
		}
	}
}

