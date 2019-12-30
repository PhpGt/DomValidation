<?php
namespace Gt\DomValidation;

use Gt\DomValidation\Rule\Pattern;
use Gt\DomValidation\Rule\Required;

class DefaultValidationRules extends ValidationRules {
	protected function setRuleList() {
		$this->ruleList = [
			new Required(),
			new Pattern(),
		];
	}
}