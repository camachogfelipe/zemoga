<?php
/**
 * The search form for our theme.
 *
 * @package WordPress
 * @subpackage Centro
 * @since Centro 1.0
 */
?>
<form role="search" class="l-stacked-right search-form" method="get" id="searchform" action="/search">
	<fieldset>
		<!--<label class="screen-reader-text" for="s">Search for:</label>-->
		<input type="text" value="" placeholder="Search" name="q" id="s">
		<input type="submit" id="searchsubmit" class="search-btn sprite-item" value="Search">
	</fieldset>
</form>