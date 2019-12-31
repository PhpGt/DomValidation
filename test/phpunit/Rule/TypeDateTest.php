<?php
namespace Gt\DomValidation\Test\Rule;

use Gt\DomValidation\Test\DomValidationTestCase;
use Gt\DomValidation\Test\Helper\Helper;
use Gt\DomValidation\ValidationException;
use Gt\DomValidation\Validator;

class TypeDateTest extends DomValidationTestCase {
	public function testTypeDate() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"dob" => "1968-11-22",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testTypeDateInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_USER_PROFILE);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"dob" => "November 22nd 1968",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$dobErrorArray = $errorArray["dob"];
			self::assertContains(
				"Field must be a date in the format Y-m-d",
				$dobErrorArray
			);
		}
	}

	public function testTypeMonth() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"month" => "2020-11",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testTypeMonthInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"month" => "November 2020",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$monthErrorArray = $errorArray["month"];
			self::assertContains(
				"Field must be a month in the format Y-m",
				$monthErrorArray
			);
		}
	}

	public function testTypeWeek() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"week" => "2021-W24",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testTypeWeekInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
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
			self::assertContains(
				"Field must be a week in the format Y-\WW",
				$monthErrorArray
			);
		}
	}

	public function testTypeWeekOutOfBounds() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"week" => "2021-W55",
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$monthErrorArray = $errorArray["week"];
			self::assertContains(
				"Field must be a week in the format Y-\WW",
				$monthErrorArray
			);
		}
	}

	public function testTypeDatetimeLocal() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		$exception = null;

		try {
			$validator->validate($form, [
				"datetime" => "2020-01-13T15:37",
			]);
		}
		catch(ValidationException $exception) {}

		self::assertNull($exception);
	}

	public function testTypeDatetimeLocalInvalid() {
		$form = self::getFormFromHtml(Helper::HTML_DATE_TIME);
		$validator = new Validator();

		try {
			$validator->validate($form, [
				"datetime" => "2020-01-13 15:37:00", // not using the correct ISO-8601 format
			]);
		}
		catch(ValidationException $exception) {
			$errorArray = iterator_to_array($validator->getLastErrorList());
			self::assertCount(1, $errorArray);
			$monthErrorArray = $errorArray["datetime"];
			self::assertContains(
				"Field must be a datetime-local in the format Y-m-d\TH:i",
				$monthErrorArray
			);
		}
	}
}