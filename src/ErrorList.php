<?php
namespace Gt\DomValidation;

use Countable;
use Gt\Dom\Element;
use Iterator;

/** @implements Iterator<string, string[]> */
class ErrorList implements Countable, Iterator {
	/** @var array<string, string[]> */
	protected array $errorArray;
	protected int $iteratorKey;

	public function __construct() {
		$this->errorArray = [];
	}

	public function add(Element $element, string $errorMessage):void {
		$name = $element->getAttribute("name");

		if(!isset($this->errorArray[$name])) {
			$this->errorArray[$name] = [];
		}

		array_push($this->errorArray[$name], $errorMessage);
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
