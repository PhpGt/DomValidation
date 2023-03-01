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

	/** @param iterable<string, string> $inputKvp Associative array of user input */
	public function validate(Element $form, iterable|object $inputKvp):void {
		$this->errorList = new ErrorList();

		if(is_object($inputKvp) && method_exists($inputKvp, "asArray")) {
			/** @var array<string, string> $inputKvp */
			$inputKvp = $inputKvp->asArray();
		}

		foreach($this->rules?->getAttributeRuleList() ?? [] as $attrString => $ruleArray) {
			$this->buildErrorList(
				$form,
				$attrString,
				$ruleArray,
				$inputKvp
			);
		}

		$errorCount = count($this->errorList);
		if($errorCount > 0) {
			$collectiveNoun = $errorCount === 1 ? "is" : "are";
			$fieldWord = $errorCount === 1 ? "field" : "fields";
			throw new ValidationException(
				"There $collectiveNoun $errorCount invalid $fieldWord"
			);
		}
	}

	public function getLastErrorList():ErrorList {
		return $this->errorList;
	}

	protected function buildErrorList(
		Element $form,
		int|string $attrString,
		mixed $ruleArray,
		iterable|object $inputKvp,
	): void {
		foreach ($form->querySelectorAll("[$attrString]") as $element) {
			$name = $element->getAttribute("name");

			foreach ($ruleArray as $rule) {
				if (!$rule->isValid($element, $inputKvp[$name] ?? "", $inputKvp)) {
					$this->errorList->add(
					$element,
					$rule->getHint($element, $inputKvp[$name] ?? "")
					);
				}
			}
		}
	}
}
