<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class MaxLengthTest extends DomValidationTestCase {
	public function testMaxLengthOK() {
		$form = self::getFormFromHtml(Helper::HTML_TWITTER);
		$validator = new Validator();

		$exception = null;
		try {
			$validator->validate($form, [
				"tweet" => "A Tweet is is a short, unintelligent and meaningless string of characters thrown into an echo chamber somewhere online."
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testMaxLength() {
		$form = self::getFormFromHtml(Helper::HTML_TWITTER);
		$validator = new Validator();

		$exception = null;
		try {
			$validator->validate($form, [
				"tweet" => "If an element has its form control maxlength attribute specified, the attribute’s value must be a valid non-negative integer. If the attribute is specified and applying the rules for parsing non-negative integers to its value results in a number, then that number is the element’s maximum allowed value length. If the attribute is omitted or parsing its value results in an error, then there is no maximum allowed value length."
			]);
		}
		catch(ValidationException $exception) {
			$errorList = iterator_to_array($validator->getLastErrorList());
			self::assertContains(
				"This field's value must contain 120 characters or less",
				$errorList["tweet"]
			);
		}
	}
}
