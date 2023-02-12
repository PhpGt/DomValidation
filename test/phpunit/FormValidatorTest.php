<?php
namespace Gt\DomValidation\Test;

use Gt\Dom\Element;
use Gt\Dom\HTMLDocument;
use Gt\DomValidation\DefaultValidationRules;
use Gt\DomValidation\Rule\Rule;
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

	/**
	 * In this example, the password field will be invalid if it contains
	 * the username.
	 */
	public function testCustomRule() {
		$usernameNotWithinPasswordRule = new class extends Rule {
			public function isValid(Element $element, string $value, array $inputKvp):bool {
				if($element->type !== "password") {
					return true;
				}

				return !str_contains($value, $inputKvp["username"]);
			}

			public function getHint(Element $element, string $value):string {
				return "The password must not contain the username";
			}
		};

		$document = new HTMLDocument(Helper::HTML_USERNAME_PASSWORD);
		$form = $document->forms[0];
		$rules = new DefaultValidationRules();
		$rules->addRule($usernameNotWithinPasswordRule);
		$validator = new Validator($rules);

		$exception = null;

		try {
			$validator->validate($form, [
				"username" => "g105b",
				"password" => "g105b-password",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$passwordErrorArray = $errorArray["password"];
			self::assertContains(
				"The password must not contain the username",
				$passwordErrorArray,
			);
		}

		self::assertNotNull($exception);
	}
}
