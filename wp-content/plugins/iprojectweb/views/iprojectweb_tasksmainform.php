<?php
/**
 * @file
 *
 * 	iProjectWebTasks main form html template
 *
 * 	@see iProjectWebTasks::getMainForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Tasks');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('GeneralInfo', 'History', 'TaskMailingList', 'TaskFiles'), 'top');?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div>
          <label><?php echo IPROJECTWEB_Title;?></label>
          <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
        </div>
        <div>
          <div style='width:450px;float:left'>
            <div>
              <label for='Notes' class='ufo-label-top'><?php echo IPROJECTWEB_Notes;?></label>
              <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
                 iProjectWebIHTML::getTinyMCE('Notes');
              endif; ?>
              <textarea id='Notes' class='ufo-formvalue' style='width:100%;height:360px'><?php echo $obj->get('Notes');?></textarea>
            </div>
          </div>
          <div style='margin-left:455px'>
            <?php if ($obj->ifRole('SuperAdmin')) : ?>
              <div>
                 <label for='Projects'><?php echo IPROJECTWEB_Project;?></label>
                 <?php iProjectWebIHTML::getAS($obj->Projects);?>
              </div>
            <?php endif; ?>
            <?php if ($obj->ifnRole('SuperAdmin')) : ?>
              <div>
                 <label><?php echo IPROJECTWEB_Projects;?></label>
                 <a id='Projects' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
                   <?php echo $obj->get('ProjectsDescription');?>
                 </a>
              </div>
            <?php endif; ?>
            <div>
              <label for='Priority'><?php echo IPROJECTWEB_Priority;?></label>
              <select id='Priority' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Priority', TRUE, 'Priorities', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='Status'><?php echo IPROJECTWEB_Status;?></label>
              <select id='Status' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Status', TRUE, 'TaskStatuses', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='Type'><?php echo IPROJECTWEB_Type;?></label>
              <select id='Type' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Type', TRUE, 'TaskTypes', 'ListPosition');?>
              </select>
            </div>
            <?php if ($obj->ifRole('SuperAdmin', 'Owner')) : ?>
              <div>
                 <label for='ObjectOwner'><?php echo IPROJECTWEB_Responsible;?></label>
                 <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
              </div>
            <?php endif; ?>
            <?php if ($obj->ifnRole('SuperAdmin', 'Owner')) : ?>
              <div>
                 <label><?php echo IPROJECTWEB_Responsible;?></label>
                 <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                   <?php echo $obj->get('ObjectOwnerDescription');?>
                 </a>
              </div>
            <?php endif; ?>
            <div>
              <label for='PlannedDeadline'><?php echo IPROJECTWEB_PlannedDeadline;?></label>
              <div class='ufo-input-wrapper'>
                 <input type='text' id='PlannedDeadline' value='<?php echo $obj->PlannedDeadline;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
                 <a id='PlannedDeadline-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
              </div>
              <input type='hidden' value='setupCalendar("PlannedDeadline", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
            </div>
            <div>
              <label for='PlannedEffort'><?php echo IPROJECTWEB_PlannedEffort;?></label>
              <input type='text' id='PlannedEffort' value='<?php echo $obj->get('PlannedEffort');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
            <div>
              <label for='ActualDeadline'><?php echo IPROJECTWEB_ActualDeadline;?></label>
              <div class='ufo-input-wrapper'>
                 <input type='text' id='ActualDeadline' value='<?php echo $obj->ActualDeadline;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
                 <a id='ActualDeadline-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
              </div>
              <input type='hidden' value='setupCalendar("ActualDeadline", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
            </div>
            <div>
              <label for='ActualEffort'><?php echo IPROJECTWEB_ActualEffort;?></label>
              <input type='text' id='ActualEffort' value='<?php echo $obj->get('ActualEffort');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
            </div>
          </div>
        </div>
      </div>
      <div id='History' class='ufo-tabs ufo-tab'>
        <div>
          <label class='ufo-label-top'><?php echo IPROJECTWEB_History;?></label>
          <div class='ufo-y-overflow'>
            <div style='width:100%;height:220px'><?php echo $obj->get('History');?></div>
          </div>
        </div>
        <div>
          <label for='Comment' class='ufo-label-top'><?php echo IPROJECTWEB_Comment;?></label>
          <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
            iProjectWebIHTML::getTinyMCE('Comment');
          endif; ?>
          <textarea id='Comment' class='ufo-formvalue' style='width:100%;height:160px'></textarea>
        </div>
      </div>
      <div id='TaskMailingList' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("TaskMailingList", {viewTarget:"UsersDiv", t:"Users", m:"mtmview", n:"manage", a:"{\"m\":\"mtmview\", \"ca\":[{\"mt\":\"Tasks_MailingLists\", \"oid\":\"<?php echo $obj->get('id');?>\", \"fld\":\"Tasks\", \"t\":\"Tasks\", \"n\":\"Contacts\"}]}"})' class='ufo-eval'>
        <div id='UsersDiv' class='mtmview innerview' style='width:270px;float:right'></div>
        <input type='hidden' value='AppMan.initRedirect("TaskMailingList", {specialfilter:"[{\"property\":\"Tasks\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Tasks_MailingListsDiv", t:"Tasks_MailingLists", m:"mtmview", n:"Tasks"}, [{property:"Tasks", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Tasks_MailingListsDiv' class='mtmview innerview' style='margin-right:275px'></div>
      </div>
      <div id='TaskFiles' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("TaskFiles", {specialfilter:"[{\"property\":\"Tasks\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"TaskFilesDiv", t:"TaskFiles", m:"viewDetailed"}, [{property:"Tasks", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='TaskFilesDiv' class='innerview'></div>
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
