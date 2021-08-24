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
}
