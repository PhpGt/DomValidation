<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class EmailTypeTest extends DomValidationTestCase {
	public function testEmail() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"email" => "jeff@amazon.com",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

// There's no need to test every permeation of invalid email addresses,
// because we can be safe in the assumption that filter_var is already
// well tested.
	public function testEmailInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"email" => "jeff.amazon.com",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$emailErrorArray = $errorArray["email"];
			self::assertContains(
				"Field must be an email address",
				$emailErrorArray
			);
		}
	}
}