<?php
namespace Gt\DomValidation\Test;

use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class FormValidatorTest extends DomValidationTestCase {
	public function testSimpleValidInput() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"username" => "g105b",
				"password" => "hunter2",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}
}