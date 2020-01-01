<?php
namespace Gt\DomValidation;

use Gt\DomValidation\Rule\Pattern;
use Gt\DomValidation\Rule\Required;
use Gt\DomValidation\Rule\TypeDate;
use Gt\DomValidation\Rule\TypeEmail;
use Gt\DomValidation\Rule\TypeNumber;
use Gt\DomValidation\Rule\TypeUrl;

class DefaultValidationRules extends ValidationRules {
	protected function setRuleList() {
		$this->ruleList = [
			new Required(),
			new Pattern(),
			new TypeNumber(),
			new TypeEmail(),
			new TypeUrl(),
			new TypeDate(),
		];
	}
}