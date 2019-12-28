<?php
namespace Gt\DomValidation\Rule;

class RequiredNotEmpty extends Rule {
	protected $attributes = [
		"required",
	];

	public function isValid(string $value):bool {
		return !empty($value);
	}

	public function getErrorMessage(string $name):string {
		return "$name field is required";
	}
}