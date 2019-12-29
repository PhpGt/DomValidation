<?php
namespace Gt\DomValidation;

use Gt\DomValidation\Rule\Pattern;
use Gt\DomValidation\Rule\RequiredNotEmpty;

class DefaultValidationRules extends ValidationRules {
	protected function setRuleList() {
		$this->ruleList = [
			new RequiredNotEmpty(),
			new Pattern(),
		];
	}
}