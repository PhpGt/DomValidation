<?php
namespace Gt\DomValidation\Rule;

abstract class Rule {
	/**
	 * @var string[] Array of attribute strings that control this rule.
	 * For attributes that take a value, separate the key and value with an
	 * equals sign (e.g. "type=email"). For attributes without a value, pass the
	 * attribute name on its own (e.g. "required").
	 */
	protected $attributes;

	public function getAttributes():array {
		return $this->attributes;
	}

	abstract public function isValid(string $value):bool;

	abstract public function getErrorMessage(string $name):string;
}