<?php
namespace Gt\DomValidation;

use Gt\DomValidation\Rule\Rule;

abstract class ValidationRules {
	/** @var Rule[] */
	protected $ruleList;

	public function __construct() {
		$this->setRuleList();
	}

	/** Must instantiate $this->ruleList as an array of Rule objects */
	abstract protected function setRuleList();

	/**
	 * Returns an associative array of rules affected by each attribute.
	 * The key of the array is the DOMElement attribute name that affects
	 * the rule(s). The value of the array is an array of Rule objects.
	 *
	 * @return Rule[]
	 */
	public function getAttributeRuleList():array {
		$attributeRuleList = [];

		foreach($this->ruleList as $rule) {
			foreach($rule->getAttributes() as $attrString) {
				if(!isset($attributeRuleList[$attrString])) {
					$attributeRuleList[$attrString] = [];
				}

				$attributeRuleList[$attrString] []= $rule;
			}
		}

		return $attributeRuleList;
	}
}