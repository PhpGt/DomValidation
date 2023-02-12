<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\Dom\HTMLDocument;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class RadioElementTest extends TestCase {
	public function testRadio() {
		$document = new HTMLDocument(Helper::HTML_RADIO);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "GBP",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testRadioMissingRequired() {
		$document = new HTMLDocument(Helper::HTML_RADIO);
		$form = $document->forms[0];
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
		$document = new HTMLDocument(Helper::HTML_RADIO);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"sort" => "desc",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testRadioTextContentInvalid() {
		$document = new HTMLDocument(Helper::HTML_RADIO);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"currency" => "USD",
				"sort" => "rand", // This <option> does not exist
			]);
		}
		catch(ValidationException) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$currencyErrorArray = $errorArray["sort"];
			self::assertContains(
				"This field's value must match one of the available options",
				$currencyErrorArray
			);
		}
	}
}
