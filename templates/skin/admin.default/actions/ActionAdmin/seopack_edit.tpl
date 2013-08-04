{extends file='_index.tpl'}

{block name="content-bar"}
    <div class="btn-group">
        <a href="{router page='admin'}seopack/" class="btn"><i class="icon-chevron-left"></i></a>
    </div>
{/block}

{block name="content-body"}

<div class="span12">
{literal}
	<script type="text/javascript">
		function toggleForm ( parameter ) {
			if($('#seopack-'+parameter+'-form-text').is(":disabled")){			
				$('#seopack-'+parameter+'-form-text').prop("disabled", false);
				$('#seopack-'+parameter+'-form-text').focus();
			}else{
				$('#seopack-'+parameter+'-form-text').prop("disabled", true);
			}
		};
	</script>
{/literal}
		
{include file='inc.modal_load_img.tpl' sToLoad='page_text'}

    <div class="b-wbox">
        <div class="b-wbox-header">
            <div class="b-wbox-header-title"> 
                {if $oSeopack}
                    {$aLang.plugin.seopack.seopack_edit}: {$oSeopack->getUrl()|strip_tags|escape:'html'}
                {else}
					{$aLang.plugin.seopack.seopack_new}                    
                {/if}
            </div>
        </div>
        <div class="b-wbox-content nopadding">
            <form action="" method="POST" class="form-horizontal uniform" enctype="multipart/form-data">
                {hook run='plugin_seopack_form_add_begin'}
                <input type="hidden" name="security_ls_key" value="{$ALTO_SECURITY_KEY}"/>
                <input type="hidden" name="seopack_id" value="{if $oSeopack}{$oSeopack->getSeopackId()}{/if}">
				
				<div class="control-group">
                    <label for="seopack_url" class="control-label">{$aLang.plugin.seopack.seopack_create_url}:</label>

                    <div class="controls">
                        <input type="text" id="url" class="input-text" name="url"
								{if $oSeopack}disabled{/if}
                               value="{if $oSeopack}{$oSeopack->getUrl()|strip_tags|escape:'html'}{/if}" />
                    </div>
                </div>
				
				<div class="control-group"> 
					<label for="title_auto" class="control-label">{$aLang.plugin.seopack.seopack_create_title}:</label>
					<div class="controls">
						<label>
							<small>
								<input type="checkbox" id="title_auto" name="title_auto" value="1"
								   class="input-checkbox" onclick="toggleForm('title');" 
								   {if !($oSeopack && $oSeopack->getTitle()!==null)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>						
						<textarea rows="5" id="seopack-title-form-text" name="title" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getTitle()!==null)}disabled{/if}>{if ($oSeopack && $oSeopack->getTitle()!==null)}{$oSeopack->getTitle()}{/if}</textarea>
					</div>
				</div>
				
				<div class="control-group"> 
					<label for="description_auto" class="control-label">{$aLang.plugin.seopack.seopack_create_description}:</label>
					<div class="controls">
						<label>
							<small>
								<input type="checkbox" id="description_auto" name="description_auto" value="1"
								   class="input-checkbox" onclick="toggleForm('description');"
								   {if !($oSeopack && $oSeopack->getDescription()!==null)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>
						<textarea rows="5" id="seopack-description-form-text" name="description" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getDescription()!==null)}disabled{/if}>{if ($oSeopack && $oSeopack->getDescription()!==null)}{$oSeopack->getDescription()}{/if}</textarea>
					</div>
				</div>
				
				<div class="control-group"> 
					<label for="keywords_auto" class="control-label">{$aLang.plugin.seopack.seopack_create_keywords}:</label>
					<div class="controls">
						<label>
							<small>
								<input type="checkbox" id="keywords_auto" name="keywords_auto" value="1"
								   class="input-checkbox" onclick="toggleForm('keywords');"
								   {if !($oSeopack && $oSeopack->getKeywords()!==null)}checked{/if}/> {$aLang.plugin.seopack.auto_generate}
							</small>
						</label>
						<textarea rows="5" id="seopack-keywords-form-text" name="keywords" class="input-text input-width-full" {if !($oSeopack && $oSeopack->getKeywords()!==null)}disabled{/if}>{if ($oSeopack && $oSeopack->getKeywords()!==null)}{$oSeopack->getKeywords()}{/if}</textarea>
					</div>
				</div>
				
                {hook run='plugin_seopack_form_add_end'}
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"
                            name="submit_seopack_save">{$aLang.plugin.seopack.seopack_create_submit_save}</button>
                </div>

            </form>
        </div>
    </div>

</div>

{/block}