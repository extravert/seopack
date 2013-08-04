<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 */

class PluginSeopack_ActionAdmin extends PluginSeopack_Inherits_ActionAdmin {
	
    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() {
		parent::RegisterEvent();
        $this->AddEvent('seopack', 'EventSeopack');		
        $this->AddEvent('seopackadd', 'EventSeopackEdit');
        $this->AddEvent('seopackedit', 'EventSeopackEdit');
        $this->AddEvent('seopackdelete', 'EventSeopackDelete');		
	}
	
	protected function EventSeopack() {
        $this->_setTitle($this->Lang_Get('plugin.seopack.seopack_title'));
        		
		$aSeopack = $this->PluginSeopack_Seopack_GetSeopackItemsAll();	
		$this->Viewer_Assign('aSeopack', $aSeopack);
		
		$this->SetTemplateAction('seopack_list');
    }
	
	protected function EventSeopackEdit() {
		$this->_setTitle($this->Lang_Get('plugin.seopack.seopack_title'));
		
		if (isPost('submit_seopack_save')) {
            $this->SubmitSaveSeopack();
        }
		
		if(Router::GetActionEvent() == 'seopackedit'){
			if ($oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId($this->GetParam(0))) {
				$this->Viewer_Assign('oSeopack', $oSeopack);
			}else {
                $this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_edit_notfound'), $this->Lang_Get('error'));
                $this->SetParam(0, null);
            }
		}
		
		$this->SetTemplateAction('seopack_edit');
	}
	protected function SubmitSaveSeopack() {
		
		if (!$this->CheckSeopackFields()) {
            return false;
        }
		
		if (!getRequest('seopack_id')) {
			if (!$oSeopack = $this->PluginSeopack_Seopack_GetSeopackByUrl( trim(getRequest('url'),"/") )){
				$oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
				$oSeopack->setUrl(trim(getRequest('url'),"/"));
			}
		}elseif (!$oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId( getRequest('seopack_id') )) {
			$oSeopack = Engine::GetEntity('PluginSeopack_ModuleSeopack_EntitySeopack');
			$oSeopack->setUrl(trim(getRequest('url'),"/"));
		}
		
		$oSeopack->setTitle(getRequest('title_auto') ? null : getRequest('title'));
		$oSeopack->setDescription(getRequest('description_auto') ? null : getRequest('description'));
		$oSeopack->setKeywords(getRequest('keywords_auto') ? null : getRequest('keywords'));
		
		if ( $oSeopack->Save() ) {
            $this->Message_AddNotice($this->Lang_Get('action.admin.pages_edit_submit_save_ok'));
            Router::Location('admin/seopack/');
        } else {
            $this->Message_AddError($this->Lang_Get('system_error'));
        }		
	}
	
	protected function EventSeopackDelete() {
		$this->Security_ValidateSendForm(); 
		
		if ($oSeopack = $this->PluginSeopack_Seopack_GetSeopackBySeopackId($this->GetParam(0))) {
			$oSeopack->Delete();
			$this->Message_AddNotice($this->Lang_Get('plugin.seopack.seopack_admin_action_delete_ok'). null, true);
			Router::Location('admin/seopack/');
		} else {
			$this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_admin_action_delete_error'), $this->Lang_Get('error'));
		}
		
		$this->SetTemplateAction('seopack_list');
	}

	protected function CheckSeopackFields() {

        $this->Security_ValidateSendForm();

        $bOk = true;

        if (isPost('title') &&  !func_check(getRequest('title', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_create_title_error'), $this->Lang_Get('error'));
            $bOk = false;
        }		
		if (isPost('description') &&  !func_check(getRequest('description', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_create_description_error'), $this->Lang_Get('error'));
            $bOk = false;
        }
		if (isPost('keywords') &&  !func_check(getRequest('keywords', '', 'post'), 'text', 0, 1000)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_create_keywords_error'), $this->Lang_Get('error'));
            $bOk = false;
        }
        if (isPost('url') &&  !func_check(getRequest('url', null, 'post'), 'text', 4, 250)) {
            $this->Message_AddError($this->Lang_Get('plugin.seopack.seopack_create_url_error'), $this->Lang_Get('error'));
            $bOk = false;
        }

        return $bOk;
    }
}