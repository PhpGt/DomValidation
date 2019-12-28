<?php
namespace Gt\DomValidation;

use DOMNode;

class Validator {
	/** @var ValidationRules */
	protected $rules;

	public function __construct(ValidationRules $rules = null) {
		if(is_null($rules)) {
			$rules = new DefaultValidationRules();
		}

		$this->rules = $rules;
	}

	/**
	 * @param DOMNode $form Form to validate
	 * @param array $input Associative array of user input
	 */
	public function validate(DomNode $form, array $input):void {

	}
}