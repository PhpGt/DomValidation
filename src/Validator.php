<?php
namespace Gt\DomValidation;

use Gt\Dom\Element;
use Gt\DomValidation\Rule\Rule;

class Validator {
	protected ?ValidationRules $rules;
	protected ErrorList $errorList;

	public function __construct(?ValidationRules $rules = null) {
		if(is_null($rules)) {
			$rules = new DefaultValidationRules();
		}

		$this->rules = $rules;
	}

	/** @param array<string, string> $input Associative array of user input */
	public function validate(Element $form, array $input):void {
		$this->errorList = new ErrorList();

		foreach($this->rules->getAttributeRuleList() as $attrString => $ruleArray) {
			/** @var Rule[] $ruleArray */

			foreach($form->querySelectorAll("[$attrString]") as $element) {
				$name = $element->getAttribute("name");

				foreach($ruleArray as $rule) {
					if(!$rule->isValid($element, $input[$name] ?? "")) {
						$this->errorList->add(
							$element,
							$rule->getHint($element, $input[$name] ?? "")
						);
					}
				}
			}
		}

		$errorCount = count($this->errorList);
		if($errorCount > 0) {
			$collectiveNoun = $errorCount === 1 ? "is" : "are";
			$fieldWord = $errorCount === 1 ? "field" : "fields";
			throw new ValidationException("There $collectiveNoun $errorCount invalid $fieldWord");
		}
	}

	public function getLastErrorList():ErrorList {
		return $this->errorList;
	}
}
