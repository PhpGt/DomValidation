<?php
namespace Gt\DomValidation;

use Gt\DomValidation\Rule\Pattern;
use Gt\DomValidation\Rule\Required;
use Gt\DomValidation\Rule\TypeEmail;
use Gt\DomValidation\Rule\TypeNumber;

class DefaultValidationRules extends ValidationRules {
	protected function setRuleList() {
		$this->ruleList = [
			new Required(),
			new Pattern(),
			new TypeNumber(),
			new TypeEmail(),
		];
	}
}