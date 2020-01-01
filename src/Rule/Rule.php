<?php
namespace Gt\DomValidation\Rule;

use DOMElement;

abstract class Rule {
	/**
	 * @var string[] Array of attribute strings that control this rule.
	 * For attributes that take a value, separate the key and value with an
	 * equals sign (e.g. "type=email"). For attributes without a value, pass the
	 * attribute name on its own (e.g. "required").
	 */
	protected $attributes = [
		"name"
	];

	public function getAttributes():array {
		return $this->attributes;
	}

	abstract public function isValid(DOMElement $element, string $value):bool;

	abstract public function getHint(DOMElement $element, string $value):string;
}