<?php
/**
 * @file
 *
 * 	iProjectWebApplicationSettings main form html template
 *
 * 	@see iProjectWebApplicationSettings::getMainForm()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-mainform ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'ApplicationSettings');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php
    iProjectWebLayout::getTabHeader(
      array(
        'GeneralSettings',
        'ProjectEmailSettings',
        'TaskEmailSettings',
        'RiskEmailSettings',
        'TinyMCESettings',
      ),
    'top')
    ?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='GeneralSettings' class='ufo-tabs ufo-tab ufo-active'>
        <div class='ufo-float-left ufo-width50'>
          <label for='ApplicationWidth'><?php echo IPROJECTWEB_ApplicationWidth;?></label>
          <input type='text' id='ApplicationWidth' value='<?php echo $obj->get('ApplicationWidth');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
          <label><?php echo IPROJECTWEB_AdminPartApplicationWidth;?></label>
          <input type='text' id='ApplicationWidth2' value='<?php echo $obj->get('ApplicationWidth2');?>' class='ufo-text ufo-formvalue' style='width:230px'>
          <label><?php echo IPROJECTWEB_DefaultStyle;?></label>
          <input type='text' id='DefaultStyle' value='<?php echo $obj->get('DefaultStyle');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
          <label><?php echo IPROJECTWEB_AdminPartDefaultStyle;?></label>
          <input type='text' id='DefaultStyle2' value='<?php echo $obj->get('DefaultStyle2');?>' class='ufo-text ufo-formvalue' style='width:230px'>
          <label><?php echo IPROJECTWEB_SecretWord;?></label>
          <input type='text' id='SecretWord' value='<?php echo $obj->get('SecretWord');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
          <label><?php echo IPROJECTWEB_FileFolder;?></label>
          <input type='text' id='FileFolder' value='<?php echo $obj->get('FileFolder');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
        </div>
        <div class='ufo-float-right ufo-width50'>
          <fieldset>
            <legend>
              <?php echo IPROJECTWEB_EmailSettings;?>
            </legend>
            <label><?php echo IPROJECTWEB_SendFrom;?></label>
            <input type='text' id='SendFrom' value='<?php echo $obj->get('SendFrom');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
            <label><?php echo IPROJECTWEB_NewCommentSubject;?></label>
            <input type='text' id='NewCommentSubject' value='<?php echo $obj->get('NewCommentSubject');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
            <label><?php echo IPROJECTWEB_StatusChangeSubject;?></label>
            <input type='text' id='StatusChangeSubject' value='<?php echo $obj->get('StatusChangeSubject');?>' class='textinput ufo-text ufo-formvalue' style='width:230px'>
          </fieldset>
          <label for='NotLoggenInText' class='ufo-label-top'><?php echo IPROJECTWEB_NotLoggedInText;?></label>
          <textarea id='NotLoggenInText' class='textinput ufo-textarea ufo-formvalue' style='width:100%;height:200px'><?php echo $obj->get('NotLoggenInText');?></textarea>
        </div>
        <div style='clear:left'></div>
      </div>
      <div id='ProjectEmailSettings' class='ufo-tabs ufo-tab'>
        <div>
          <label for='Projects_NotifyOnStatusChange'><?php echo IPROJECTWEB_NotifyOnStatusChange;?></label>
          <input type='checkbox' id='Projects_NotifyOnStatusChange' value='<?php echo $obj->Projects_NotifyOnStatusChange;?>' <?php echo $obj->Projects_NotifyOnStatusChangeChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Projects_NotifyOnNewComment'><?php echo IPROJECTWEB_NotifyOnNewComment;?></label>
          <input type='checkbox' id='Projects_NotifyOnNewComment' value='<?php echo $obj->Projects_NotifyOnNewComment;?>' <?php echo $obj->Projects_NotifyOnNewCommentChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Projects_EmailFormatHTML'><?php echo IPROJECTWEB_HtmlFormat;?></label>
          <input type='checkbox' id='Projects_EmailFormatHTML' value='<?php echo $obj->Projects_EmailFormatHTML;?>' <?php echo $obj->Projects_EmailFormatHTMLChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
        </div>
        <div>
          <div style='width:130px;float:right;padding-top:20px'>
            <?php $obj->getEmailTemplate('Projects');?>
          </div>
          <div style='margin-right:130px;overflow:auto;padding-right:15px'>
            <label for='Projects_EmailTemplate' class='ufo-label-top'><?php echo IPROJECTWEB_EmailTemplate;?></label>
            <textarea id='Projects_EmailTemplate' class='textinput ufo-textarea ufo-formvalue' style='width:100%;height:261px'><?php echo $obj->get('Projects_EmailTemplate');?></textarea>
          </div>
        </div>
      </div>
      <div id='TaskEmailSettings' class='ufo-tabs ufo-tab'>
        <div>
          <label for='Tasks_NotifyOnStatusChange'><?php echo IPROJECTWEB_NotifyOnStatusChange;?></label>
          <input type='checkbox' id='Tasks_NotifyOnStatusChange' value='<?php echo $obj->Tasks_NotifyOnStatusChange;?>' <?php echo $obj->Tasks_NotifyOnStatusChangeChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Tasks_NotifyOnNewComment'><?php echo IPROJECTWEB_NotifyOnNewComment;?></label>
          <input type='checkbox' id='Tasks_NotifyOnNewComment' value='<?php echo $obj->Tasks_NotifyOnNewComment;?>' <?php echo $obj->Tasks_NotifyOnNewCommentChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Tasks_EmailFormatHTML'><?php echo IPROJECTWEB_HtmlFormat;?></label>
          <input type='checkbox' id='Tasks_EmailFormatHTML' value='<?php echo $obj->Tasks_EmailFormatHTML;?>' <?php echo $obj->Tasks_EmailFormatHTMLChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
        </div>
        <div>
          <div style='width:130px;float:right;padding-top:20px'>
            <?php $obj->getEmailTemplate('Tasks');?>
          </div>
          <div style='margin-right:130px;overflow:auto;padding-right:15px'>
            <label for='Tasks_EmailTemplate' class='ufo-label-top'><?php echo IPROJECTWEB_EmailTemplate;?></label>
            <textarea id='Tasks_EmailTemplate' class='textinput ufo-textarea ufo-formvalue' style='width:100%;height:261px'><?php echo $obj->get('Tasks_EmailTemplate');?></textarea>
          </div>
        </div>
      </div>
      <div id='RiskEmailSettings' class='ufo-tabs ufo-tab'>
        <div>
          <label for='Risks_NotifyOnStatusChange'><?php echo IPROJECTWEB_NotifyOnStatusChange;?></label>
          <input type='checkbox' id='Risks_NotifyOnStatusChange' value='<?php echo $obj->Risks_NotifyOnStatusChange;?>' <?php echo $obj->Risks_NotifyOnStatusChangeChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Risks_NotifyOnNewComment'><?php echo IPROJECTWEB_NotifyOnNewComment;?></label>
          <input type='checkbox' id='Risks_NotifyOnNewComment' value='<?php echo $obj->Risks_NotifyOnNewComment;?>' <?php echo $obj->Risks_NotifyOnNewCommentChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
          <label for='Risks_EmailFormatHTML'><?php echo IPROJECTWEB_HtmlFormat;?></label>
          <input type='checkbox' id='Risks_EmailFormatHTML' value='<?php echo $obj->Risks_EmailFormatHTML;?>' <?php echo $obj->Risks_EmailFormatHTMLChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
        </div>
        <div>
          <div style='width:130px;float:right;padding-top:20px'>
            <?php $obj->getEmailTemplate('Risks');?>
          </div>
          <div style='margin-right:130px;overflow:auto;padding-right:15px'>
            <label for='Risks_EmailTemplate' class='ufo-label-top'><?php echo IPROJECTWEB_EmailTemplate;?></label>
            <textarea id='Risks_EmailTemplate' class='textinput ufo-textarea ufo-formvalue' style='width:100%;height:261px'><?php echo $obj->get('Risks_EmailTemplate');?></textarea>
          </div>
        </div>
      </div>
      <div id='TinyMCESettings' class='ufo-tabs ufo-tab'>
        <label for='UseTinyMCE'><?php echo IPROJECTWEB_UseTinyMCE;?></label>
        <input type='checkbox' id='UseTinyMCE' value='<?php echo $obj->UseTinyMCE;?>' <?php echo $obj->UseTinyMCEChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
        <label for='TinyMCEConfig' class='ufo-label-top'><?php echo IPROJECTWEB_TinyMCEConfig;?></label>
        <textarea id='TinyMCEConfig' class='textinput ufo-textarea ufo-formvalue' style='width:100%;height:330px'><?php echo $obj->get('TinyMCEConfig');?></textarea>
      </div>
    </div>
  </div>
  <div>
    <div class='ufo-float-left'>
      <?php echo iProjectWebIHTML::getButton(
        array(
          'label' => IPROJECTWEB_OK,
          'events' => " onclick='plainsave($obj->jsconfig)'",
          'iclass' => " class='icon_button_save' ",
          'bclass' => "button internalimage",
        )
      );?>
    </div>
    <div class='ufo-float-left'>
      <?php echo iProjectWebIHTML::getButton(
        array(
          'label' => IPROJECTWEB_Help,
          'events' => " onclick='$obj->helpLink'",
          'iclass' => " class='icon_menu_help' ",
          'bclass' => "button internalimage",
        )
      );?>
    </div>
    <div style='clear:left'></div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
