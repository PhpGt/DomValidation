<?php
namespace Gt\DomValidation\Test\Helper;

class Helper {
	const HTML_USERNAME_PASSWORD = <<<HTML
<!doctype html>
<form method="post">
	<label>
		<span>Username</span>
		<input name="username" required />
	</label>
	<label>
		<span>Password</span>
		<input name="password" type="password" required />
	</label>
	<button name="do" value="login">Log in!</button>
</form>
HTML;

	const HTML_PATTERN_CREDIT_CARD = <<<HTML
<!doctype html>
<form method="post">
	<label>
		<span>Your name</span>
		<input name="name" required />	
	</label>
	<label>
		<span>Credit Card number</span>
		<input name="credit-card" pattern="\d{16}" />
	</label>
	<label>
		<span>Expiry month</span>
		<input name="expiry-month" type="number" min="1" max="12" />	
	</label>
	<label>
		<span>Expiry year</span>
		<input name="expiry-year" type="number" min="18" max="26" />
	</label>
	<label>
		<span>amount</span>
		<input name="amount" type="number" />
	</label>
	<button name="do" value="buy">Buy the thing!</button>
</form>
HTML;

	const HTML_PATTERN_CREDIT_CARD_ALL_REQUIRED_FIELDS = <<<HTML
<!doctype html>
<form method="post">
	<label>
		<span>Your name</span>
		<input name="name" required />	
	</label>
	<label>
		<span>Credit Card number</span>
		<input name="credit-card" pattern="\d{16}" required />
	</label>
	<label>
		<span>Expiry month</span>
		<input name="expiry-month" type="number" min="1" max="12" required />	
	</label>
	<label>
		<span>Expiry year</span>
		<input name="expiry-year" type="number" min="18" max="26" required />
	</label>
	<label>
		<span>amount</span>
		<input name="amount" type="number" required />
	</label>
	<button name="do" value="buy">Buy the thing!</button>
</form>
HTML;


}