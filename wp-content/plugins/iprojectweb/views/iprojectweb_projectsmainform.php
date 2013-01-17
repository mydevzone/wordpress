<?php
/**
 * @file
 *
 * 	iProjectWebProjects main form html template
 *
 * 	@see iProjectWebProjects::getMainForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Projects');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php
    iProjectWebLayout::getTabHeader(
      array(
        'GeneralInfo',
        'ProjectTeam',
        'Tasks',
        'Risks',
        'ProjectMailingList',
        'ProjectFiles',
        'History',
        'More',
      ),
    'left')
    ?>
    <div class='ufo-tab-wrapper ufo-tab-left'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div>
          <label><?php echo IPROJECTWEB_Title;?></label>
          <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
        </div>
        <div>
          <div class='ufo-float-left ufo-width50'>
            <div>
              <label for='Status'><?php echo IPROJECTWEB_Status;?></label>
              <select id='Status' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Status', TRUE, 'ProjectStatuses', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='StartDate'><?php echo IPROJECTWEB_StartDate;?></label>
              <div class='ufo-input-wrapper'>
                 <input type='text' id='StartDate' value='<?php echo $obj->StartDate;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
                 <a id='StartDate-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
              </div>
              <input type='hidden' value='setupCalendar("StartDate", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
            </div>
            <div>
              <label for='FinishDate'><?php echo IPROJECTWEB_FinishDate;?></label>
              <div class='ufo-input-wrapper'>
                 <input type='text' id='FinishDate' value='<?php echo $obj->FinishDate;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
                 <a id='FinishDate-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
              </div>
              <input type='hidden' value='setupCalendar("FinishDate", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
            </div>
          </div>
          <div class='ufo-float-right ufo-width50'>
            <?php if ($obj->ifRole('SuperAdmin')) : ?>
              <div>
                 <label for='ObjectOwner'><?php echo IPROJECTWEB_Manager;?></label>
                 <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
              </div>
            <?php endif; ?>
            <?php if ($obj->ifnRole('SuperAdmin')) : ?>
              <div>
                 <label><?php echo IPROJECTWEB_Manager;?></label>
                 <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                   <?php echo $obj->get('ObjectOwnerDescription');?>
                 </a>
              </div>
            <?php endif; ?>
            <div>
              <label for='ProjectField1'><?php echo IPROJECTWEB_ProjectField1;?></label>
              <select id='ProjectField1' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'ProjectField1', TRUE, 'ProjectField1');?>
              </select>
            </div>
            <div>
              <label for='ProjectField2'><?php echo IPROJECTWEB_ProjectField2;?></label>
              <select id='ProjectField2' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'ProjectField2', TRUE, 'ProjectField2');?>
              </select>
            </div>
          </div>
          <div style='clear:left'></div>
        </div>
        <div>
          <div>
            <label for='ProjectDescription' class='ufo-label-top'><?php echo IPROJECTWEB_ProjectDescription;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('ProjectDescription');
            endif; ?>
            <textarea id='ProjectDescription' class='ufo-formvalue' style='width:100%;height:194px'><?php echo $obj->get('ProjectDescription');?></textarea>
          </div>
        </div>
      </div>
      <div id='ProjectTeam' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectTeam", {viewTarget:"UsersDiv1", t:"Users", m:"mtmview", n:"manage", a:"{\"m\":\"mtmview\", \"ca\":[{\"mt\":\"Projects_Teams\", \"oid\":\"<?php echo $obj->get('id');?>\", \"fld\":\"Projects\", \"t\":\"Projects\", \"n\":\"Members\"}]}"})' class='ufo-eval'>
        <div id='UsersDiv1' class='mtmview innerview' style='width:270px;float:right'></div>
        <input type='hidden' value='AppMan.initRedirect("ProjectTeam", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_TeamsDiv", t:"Projects_Teams", m:"mtmview", n:"Projects"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Projects_TeamsDiv' class='mtmview innerview' style='margin-right:275px'></div>
      </div>
      <div id='Tasks' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("Tasks", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"TasksDiv", t:"Tasks", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='TasksDiv' class='innerview'></div>
      </div>
      <div id='Risks' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("Risks", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"RisksDiv", t:"Risks", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='RisksDiv' class='innerview'></div>
      </div>
      <div id='ProjectMailingList' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectMailingList", {viewTarget:"UsersDiv2", t:"Users", m:"mtmview", n:"manage", a:"{\"m\":\"mtmview\", \"ca\":[{\"mt\":\"Projects_MailingLists\", \"oid\":\"<?php echo $obj->get('id');?>\", \"fld\":\"Projects\", \"t\":\"Projects\", \"n\":\"Contacts\"}]}"})' class='ufo-eval'>
        <div id='UsersDiv2' class='mtmview innerview' style='width:270px;float:right'></div>
        <input type='hidden' value='AppMan.initRedirect("ProjectMailingList", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_MailingListsDiv", t:"Projects_MailingLists", m:"mtmview", n:"Projects"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Projects_MailingListsDiv' class='mtmview innerview' style='margin-right:275px'></div>
      </div>
      <div id='ProjectFiles' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectFiles", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"ProjectFilesDiv", t:"ProjectFiles", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='ProjectFilesDiv' class='innerview'></div>
      </div>
      <div id='History' class='ufo-tabs ufo-tab'>
        <div>
          <label class='ufo-label-top'><?php echo IPROJECTWEB_History;?></label>
          <div class='ufo-y-overflow'>
            <div style='width:100%;height:177px'><?php echo $obj->get('History');?></div>
          </div>
        </div>
        <div>
          <label for='Comment' class='ufo-label-top'><?php echo IPROJECTWEB_Comment;?></label>
          <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
            iProjectWebIHTML::getTinyMCE('Comment');
          endif; ?>
          <textarea id='Comment' class='ufo-formvalue' style='width:100%;height:150px'></textarea>
        </div>
      </div>
      <div id='More' class='ufo-tabs ufo-tab'>
        <div>
          <div>
            <label for='ProjectField3' class='ufo-label-top'><?php echo IPROJECTWEB_ProjectField3;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('ProjectField3');
            endif; ?>
            <textarea id='ProjectField3' class='ufo-formvalue' style='width:100%'><?php echo $obj->get('ProjectField3');?></textarea>
          </div>
          <div>
            <label for='ProjectField4' class='ufo-label-top'><?php echo IPROJECTWEB_ProjectField4;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('ProjectField4');
            endif; ?>
            <textarea id='ProjectField4' class='ufo-formvalue' style='width:100%;height:182px'><?php echo $obj->get('ProjectField4');?></textarea>
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
