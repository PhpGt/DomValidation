<?php
namespace Gt\DomValidation\Test;

use Gt\Dom\HTMLDocument;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class FormValidatorTest extends TestCase {
	public function testSimpleValidInput() {
		$document = new HTMLDocument(Helper::HTML_USERNAME_PASSWORD);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"username" => "g105b",
				"password" => "hunter222222",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}
}
