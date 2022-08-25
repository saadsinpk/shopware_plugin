{* Extend the base template to get the header, navbar etc *}
{extends file="parent:frontend/index/index.tpl"}

{* Overwrite the main content section to add some custom content*}
{block name="frontend_index_content"}
	{$listingCssClass = "listing--wrapper"}
	<div class="content listing--content">
		<form action="{url controller="SwagControllerTest"}" method="post" style="    width: 100%;">
		    <div style="display:flex;align-items: flex-end;gap: 20px;">
		      <div>
		        <label for="length_input_filter" style="">Length</label>
		        <input type="text" id="length_input_filter" placement="Length" class="form-control" style="width: 100%;" name="length_input_filter" value="{$length_input_filter}">
		      </div>
		      <div>
		        <label for="height_input_filter">Height</label>
		        <input type="text" id="height_input_filter" placement="Height" class="form-control" style="width: 100%;" name="height_input_filter" value="{$height_input_filter}">
		      </div>
		      <div>
		        <label for="width_input_filter">Width</label>
		        <input type="text" id="width_input_filter" placement="Width" class="form-control" style="width: 100%;" name="width_input_filter" value="{$width_input_filter}">
		      </div>
		      <div>
		        <label></label>
		        <input type="submit" value="Submit" class="form-control" style="width: 100%;background: #e14711;border: transparent;padding: 10px;color: #fff;/* margin-top: 10px; */">
		      </div>
		    </div>
		    <div style="clear:both;"></div>
		</form>

		<hr>
		<div class="{$listingCssClass}">

		    {block name="frontend_listing_listing_container"}
		        <div class="listing--container">


		            {block name="frontend_listing_listing_content"}
		                <div class="listing"
		                     data-ajax-wishlist="true"
		                     data-compare-ajax="true"
		                        {if $theme.infiniteScrolling}
		                            data-infinite-scrolling="true"
		                            data-loadPreviousSnippet="{s name="ListingActionsLoadPrevious"}{/s}"
		                            data-loadMoreSnippet="{s name="ListingActionsLoadMore"}{/s}"
		                            data-categoryId="{$sCategoryContent.id}"
		                            data-pages="{$pages}"
		                            data-threshold="{$theme.infiniteThreshold}"
		                            data-pageShortParameter="{$shortParameters.sPage}"
		                        {/if}>

		                    {* Actual listing *}
		                    {block name="frontend_listing_list_inline"}
		                        {foreach $sSearchResults['sArticles'] as $sArticle}
		                            {include file="frontend/listing/box_article.tpl"}
		                        {/foreach}
		                    {/block}
		                </div>
		            {/block}
		        </div>
		    {/block}

		    {* Paging *}
		    {block name="frontend_listing_bottom_paging"}
		        <div class="listing--bottom-paging">
		            {include file="frontend/listing/actions/action-pagination.tpl"}
		        </div>
		    {/block}
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		jQuery( document ).ready(function() {
			jQuery("body").attr("class","is--ctl-listing is--act-index");
		});
	</script>
{/block}