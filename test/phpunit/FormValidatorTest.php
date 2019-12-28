<?php
namespace Gt\DomValidation\Test;

use DOMDocument;
use DOMNode;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class FormValidatorTest extends TestCase {
	private static function getFormFromHtml(string $html):DOMNode {
		$document = new DOMDocument("1.0", "utf-8");
		$document->loadHTML(Helper::HTML_USERNAME_PASSWORD);

		return $document->getElementsByTagName(
			"form"
		)->item(
			0
		);
	}

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
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}
}