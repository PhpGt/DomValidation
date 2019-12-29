<?php
namespace Gt\DomValidation;

use DOMElement;
use Countable;
use Iterator;

class ErrorList implements Countable, Iterator {
	protected $errorArray;
	protected $iteratorKey;
	protected $iteratorString;

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

	public function rewind():void {
		$this->iteratorKey = 0;
	}

	public function valid():bool {
		$keys = array_keys($this->errorArray);
		return isset($keys[$this->iteratorKey]);
	}

	public function current():array {
		$keys = array_keys($this->errorArray);
		return $this->errorArray[$keys[$this->iteratorKey]];
	}

	public function next():void {
		$this->iteratorKey++;
	}

	public function key():string {
		$keys = array_keys($this->errorArray);
		return $keys[$this->iteratorKey];
	}
}