<?php
namespace Gt\DomValidation\Test;

use Gt\Dom\HTMLDocument;
use Gt\Dom\HTMLElement\HTMLFormElement;
use PHPUnit\Framework\TestCase;

class DomValidationTestCase extends TestCase {
	public static function getFormFromHtml(string $html):HTMLFormElement {
		$document = new HTMLDocument($html);
		/** @var HTMLFormElement $form */
		/** @noinspection PhpUnnecessaryLocalVariableInspection */
		$form = $document->forms[0];
		return $form;
	}
}
