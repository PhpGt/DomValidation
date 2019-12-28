<?php
namespace Gt\DomValidation;

use Countable;
use DOMElement;

class ErrorList implements Countable {
	protected $errorArray;

	public function __construct() {
		$this->errorArray = [];
	}

	public function add(DOMElement $element, string $errorMessage):void {
		$name = $element->getAttribute("name");

		if(!isset($this->errorArray[$name])) {
			$this->errorArray[$name] = [];
		}

		$this->errorArray[$name] []= $errorMessage;
	}

	public function count():int {
		return count($this->errorArray);
	}
}