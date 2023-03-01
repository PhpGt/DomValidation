<?php
namespace Gt\DomValidation\Rule;

use Gt\Dom\Element;

abstract class Rule {
	/**
	 * @var string[] Array of attribute strings that control this rule.
	 * For attributes that take a value, separate the key and value with an
	 * equals sign (e.g. "type=email"). For attributes without a value, pass the
	 * attribute name on its own (e.g. "required").
	 */
	protected array $attributes = [
		"name"
	];

	/** @return string[] */
	public function getAttributes():array {
		return $this->attributes;
	}

	abstract public function isValid(Element $element, string $value, array $inputKvp):bool;

	abstract public function getHint(Element $element, string $value):string;
}
