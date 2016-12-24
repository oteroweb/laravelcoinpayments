<?php
/**
 *
 * @author Jose Otero <oterolopez1990@gmail.com>
 *
 */
?>
<form action="" method="POST">
    <input type="text" name="PAYMENT_AMOUNT" value="{{ $PAYMENT_AMOUNT }}" placeholder="Amount">
	@if($STATUS_URL)
		<input type="hidden" name="STATUS_URL" value="{{ $STATUS_URL }}">
	@endif
    <input type="submit" value="Proceed">
</form>