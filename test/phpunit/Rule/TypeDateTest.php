<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\Dom\HTMLDocument;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;
use PHPUnit\Framework\TestCase;

class TypeDateTest extends TestCase {
	public function testTypeDate() {
		$document = new HTMLDocument(Helper::HTML_USER_PROFILE);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"dob" => "1968-11-22",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testTypeDateInvalid() {
		$document = new HTMLDocument(Helper::HTML_USER_PROFILE);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"dob" => "November 22nd 1968",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			self::assertSame(
				"Field must be a date in the format Y-m-d",
				$errorArray["dob"]
			);
		}
	}

	public function testTypeMonth() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"month" => "2020-11",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testTypeMonthInvalid() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"month" => "November 2020",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			self::assertSame(
				"Field must be a month in the format Y-m",
				$errorArray["month"]
			);
		}
	}

	public function testTypeWeek() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"week" => "2021-W24",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testTypeWeekInvalid() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"week" => "2021, Week 24",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$monthErrorArray = $errorArray["week"];
			self::assertSame(
				"Field must be a week in the format Y-\WW",
				$monthErrorArray
			);
		}
	}

	public function testTypeWeekOutOfBounds() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"week" => "2021-W55",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			self::assertSame(
				"Field must be a week in the format Y-\WW",
				$errorArray["week"]
			);
		}
	}

	public function testTypeDatetimeLocal() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"datetime" => "2020-01-13T15:37",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testTypeDatetimeLocalInvalid() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"datetime" => "2020-01-13 15:37:00", // not using the correct ISO-8601 format
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			self::assertSame(
				"Field must be a datetime-local in the format Y-m-d\TH:i",
				$errorArray["datetime"]
			);
		}
	}

	public function testTypeTime() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"time" => "15:37",
			]);
		}
		catch(ValidationException $exception) {
		}

		self::assertNull($exception);
	}

	public function testTypeTimeInvalid() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"time" => "3:37pm",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			self::assertSame(
				"Field must be a time in the format H:i",
				$errorArray["time"]
			);
		}
	}

	public function testTypeAttributeMissing() {
		$document = new HTMLDocument("<form><input name='time' /></form>");
		$form = $document->forms[0];
		$validator = new Validator();

		$exception = null;
		try {
			$validator->validate($form, [
				"time" => "3:37pm",
			]);
		}
		catch(ValidationException $exception) {}
		self::assertNull($exception);
	}

	public function testTypeNotKnown() {
		$document = new HTMLDocument(Helper::HTML_DATE_TIME);
		$form = $document->forms[0];
		$timeInput = $form->querySelector("[type='time']");
		$timeInput->type = "unknown";

		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"time" => "3:37pm",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}
}
