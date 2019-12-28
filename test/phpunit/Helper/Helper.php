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
	<button name="do" value="login">Log in</button>
</form>
HTML;

}