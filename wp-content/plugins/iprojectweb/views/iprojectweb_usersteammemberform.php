<?php
/**
 * @file
 *
 * 	iProjectWebUsers TeamMember form html template
 *
 * 	@see iProjectWebUsers::getTeamMemberForm()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-teammemberform ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Users', 'Name,Description');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('GeneralInfo', 'Photos', 'ProjectTeams', 'MailingLists', 'More'), 'left', '1');?>
    <div class='ufo-tab-wrapper ufo-tab-left'>
      <div id='GeneralInfo1' class='ufo-tabs ufo-tab1 ufo-active'>
        <div>
          <div class='ufo-float-left ufo-width50'>
            <div>
              <label><?php echo IPROJECTWEB_FirstName;?></label>
              <input type='text' id='Name' value='<?php echo $obj->get('Name');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_LastName;?></label>
              <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label for='Birthday'><?php echo IPROJECTWEB_Birthday;?></label>
              <div class='ufo-input-wrapper'>
                 <input type='text' id='Birthday' value='<?php echo $obj->Birthday;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
                 <a id='Birthday-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
              </div>
              <input type='hidden' value='setupCalendar("Birthday", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_email;?></label>
              <input type='text' id='email' value='<?php echo $obj->get('email');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
          </div>
          <div class='ufo-float-right ufo-width50'>
            <div>
              <label><?php echo IPROJECTWEB_Cell;?></label>
              <input type='text' id='Cell' value='<?php echo $obj->get('Cell');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_Phone;?></label>
              <input type='text' id='Phone' value='<?php echo $obj->get('Phone');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_SkypeId;?></label>
              <input type='text' id='SkypeId' value='<?php echo $obj->get('SkypeId');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_email2;?></label>
              <input type='text' id='email2' value='<?php echo $obj->get('email2');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
          </div>
          <div style='clear:left'></div>
        </div>
        <div>
          <label for='About' class='ufo-label-top'><?php echo IPROJECTWEB_About;?></label>
          <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
            iProjectWebIHTML::getTinyMCE('About');
          endif; ?>
          <textarea id='About' class='ufo-formvalue' style='width:100%;height:200px'><?php echo $obj->get('About');?></textarea>
        </div>
      </div>
      <div id='Photos1' class='ufo-tabs ufo-tab1'>
        <div style='width:200px;float:right'>
          <label for='thumbPhoto' style='float:none'><?php echo IPROJECTWEB_thumbPhoto;?></label>
          <?php iProjectWebIHTML::getFileUpload('thumbPhoto', $obj->thumbPhoto);?>
          <div style='clear:left'>
            <?php iProjectWebIHTML::getFileDownloadLink($obj->thumbPhotoImg);?>
          </div>
        </div>
        <div style='margin-right:205px'>
          <div style='clear:left;overflow:hidden'>
            <label for='Photo' style='float:none'><?php echo IPROJECTWEB_Photo;?></label>
            <?php iProjectWebIHTML::getFileUpload('Photo', $obj->Photo);?>
          </div>
          <div style='clear:left'>
            <?php iProjectWebIHTML::getFileDownloadLink($obj->PhotoImg);?>
          </div>
        </div>
      </div>
      <div id='ProjectTeams1' class='ufo-tabs ufo-tab1'>
        <input type='hidden' value='AppMan.initRedirect("ProjectTeams1", {specialfilter:"[{\"property\":\"Members\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_TeamsDiv", t:"Projects_Teams", m:"mtmview", n:"Users"}, [{property:"Members", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Projects_TeamsDiv' class='mtmview innerview'></div>
      </div>
      <div id='MailingLists1' class='ufo-tabs ufo-tab1'>
        <?php iProjectWebLayout::getTabHeader(array('ProjectMailingLists', 'TaskMailingLists', 'RiskMailingLists'), 'top', '2');?>
        <div class='ufo-tab-wrapper ufo-tab-top'>
          <div id='ProjectMailingLists2' class='ufo-tabs ufo-tab2 ufo-active'>
            <input type='hidden' value='AppMan.initRedirect("ProjectMailingLists2", {specialfilter:"[{\"property\":\"Contacts\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_MailingListsDiv", t:"Projects_MailingLists", m:"mtmview", n:"Users"}, [{property:"Contacts", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
            <div id='Projects_MailingListsDiv' class='mtmview innerview'></div>
          </div>
          <div id='TaskMailingLists2' class='ufo-tabs ufo-tab2'>
            <input type='hidden' value='AppMan.initRedirect("TaskMailingLists2", {specialfilter:"[{\"property\":\"Contacts\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Tasks_MailingListsDiv", t:"Tasks_MailingLists", m:"mtmview", n:"Users"}, [{property:"Contacts", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
            <div id='Tasks_MailingListsDiv' class='mtmview innerview'></div>
          </div>
          <div id='RiskMailingLists2' class='ufo-tabs ufo-tab2'>
            <input type='hidden' value='AppMan.initRedirect("RiskMailingLists2", {specialfilter:"[{\"property\":\"Contacts\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Risks_MailingListsDiv", t:"Risks_MailingLists", m:"mtmview", n:"Users"}, [{property:"Contacts", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
            <div id='Risks_MailingListsDiv' class='mtmview innerview'></div>
          </div>
        </div>
      </div>
      <div id='More1' class='ufo-tabs ufo-tab1'>
        <div>
          <div>
            <label for='UserField3' class='ufo-label-top'><?php echo IPROJECTWEB_UserField3;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('UserField3');
            endif; ?>
            <textarea id='UserField3' class='ufo-formvalue' style='width:100%'><?php echo $obj->get('UserField3');?></textarea>
          </div>
          <div>
            <label for='UserField4' class='ufo-label-top'><?php echo IPROJECTWEB_UserField4;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('UserField4');
            endif; ?>
            <textarea id='UserField4' class='ufo-formvalue' style='width:100%;height:188px'><?php echo $obj->get('UserField4');?></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='ufo-float-left'>
      <?php echo iProjectWebIHTML::getButton(
        array(
          'label' => IPROJECTWEB_OK,
          'events' => " onclick='save($obj->jsconfig)'",
          'iclass' => " class='icon_button_save' ",
          'bclass' => "button internalimage",
        )
      );?>
    </div>
    <div class='ufo-float-left'>
      <?php echo iProjectWebIHTML::getButton(
        array(
          'label' => IPROJECTWEB_Apply,
          'events' => " onclick='apply($obj->jsconfig)'",
          'iclass' => " class='icon_button_apply' ",
          'bclass' => "button internalimage",
        )
      );?>
    </div>
    <div class='ufo-float-left'>
      <?php echo iProjectWebIHTML::getButton(
        array(
          'label' => IPROJECTWEB_Back,
          'events' => " onclick='back()'",
          'iclass' => " class='icon_button_back' ",
          'bclass' => "button internalimage",
        )
      );?>
    </div>
    <div style='clear:left'></div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
