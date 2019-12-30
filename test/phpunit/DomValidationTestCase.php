<?php
namespace Gt\DomValidation\Test;

use DOMDocument;
use DOMElement;
use PHPUnit\Framework\TestCase;

class DomValidationTestCase extends TestCase {
	public static function getFormFromHtml(string $html):DOMElement {
		$document = new DOMDocument("1.0", "utf-8");
		$document->loadHTML($html);

		/** @var DOMElement $domElement */
		$domElement = $document->getElementsByTagName(
			"form"
		)->item(
			0
		);
		return $domElement;
	}
}