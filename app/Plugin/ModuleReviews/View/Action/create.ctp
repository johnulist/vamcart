	<a href="{base_path}/product/{$content_alias}.html">{$content_name}</a>
	<br />
	<hr />
	<div class="css_form">
	<div class="review">
	<form action="{base_path}/module_reviews/action/create/" method="post">
	<input type="hidden" name="content_id" value="{$content_id}" />
	<div>
		<label for="name">{lang}Name{/lang}</label>
		<input type="text" name="name" id="name" />
	</div>
	<div>
		<label for="review">{lang}Review{/lang}</label>
		<textarea name="content"></textarea>
	</div>
	<div>
		<span class="button"><button type="submit" value="{lang}Submit{/lang}">{lang}Submit{/lang}</button></span>
	</div>
	</form>
	</div>
</div>