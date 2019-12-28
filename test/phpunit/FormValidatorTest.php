<?php
namespace Gt\DomValidation\Test;

use DOMDocument;
use DOMElement;
use DOMNode;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class FormValidatorTest extends TestCase {
	private static function getFormFromHtml(string $html):DOMElement {
		$document = new DOMDocument("1.0", "utf-8");
		$document->loadHTML(Helper::HTML_USERNAME_PASSWORD);

		/** @var DOMElement $domElement */
		$domElement = $document->getElementsByTagName(
			"form"
		)->item(
			0
		);
		return $domElement;
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

	public function testSimpleMissingRequiredInput() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		self::expectException(ValidationException::class);
		self::expectExceptionMessage("There is 1 invalid field");

		$validator->validate($form, [
			"username" => "g105b",
		]);
	}

	public function testSimpleMissingBothRequiredInputs() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		self::expectException(ValidationException::class);
		self::expectExceptionMessage("There are 2 invalid fields");

		$validator->validate($form, ["something" => "nothing"]);
	}

	public function testSimpleMissingRequiredInputErrorList() {
		$form = self::getFormFromHtml(Helper::HTML_USERNAME_PASSWORD);
		$validator = new Validator();

		try {
			$validator->validate($form, ["username" => "g105b"]);
		}
		catch(ValidationException $exception) {
			foreach($validator->getLastErrorList() as $name => $errors) {
				self::assertIsArray($errors);
				self::assertContains("This field is required", $errors);
				self::assertCount(1, $errors);
			}
		}
	}
}