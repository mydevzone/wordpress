<?php
/**
 * @file
 *
 * 	iProjectWebTasks readonly form html template
 *
 * 	@see iProjectWebTasks::getReadonlyForm()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-readonlyform ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Tasks');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('GeneralInfo', 'History', 'TaskMailingList', 'TaskFiles'), 'top');?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div></div>
        <div>
          <div style='width:450px;float:left'>
            <div>
              <label class='ufo-label-top'><?php echo IPROJECTWEB_Notes;?></label>
              <div class='ufo-y-overflow'>
                 <div style='width:100%;height:360px'><?php echo $obj->get('Notes');?></div>
              </div>
            </div>
          </div>
          <div style='margin-left:455px'>
            <div>
              <label><?php echo IPROJECTWEB_Project;?></label>
              <?php echo $obj->get('ProjectsDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Priority;?></label>
              <?php echo $obj->get('PriorityDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Status;?></label>
              <?php echo $obj->get('StatusDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Type;?></label>
              <?php echo $obj->get('TypeDescription');?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_Responsible;?></label>
              <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                 <?php echo $obj->get('ObjectOwnerDescription');?>
              </a>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_PlannedDeadline;?></label>
              <?php iProjectWebIHTML::echoDate($obj->get('PlannedDeadline'), IPROJECTWEB_DateFormat, 0);?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_PlannedEffort;?></label>
              <?php echo $obj->get('PlannedEffort');?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_ActualDeadline;?></label>
              <?php iProjectWebIHTML::echoDate($obj->get('ActualDeadline'), IPROJECTWEB_DateFormat, 0);?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_ActualEffort;?></label>
              <?php echo $obj->get('ActualEffort');?>
            </div>
          </div>
        </div>
      </div>
      <div id='History' class='ufo-tabs ufo-tab'>
        <div>
          <label class='ufo-label-top'><?php echo IPROJECTWEB_History;?></label>
          <div class='ufo-y-overflow'>
            <div style='width:100%;height:190px'><?php echo $obj->get('History');?></div>
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
        <input type='hidden' value='AppMan.initRedirect("TaskMailingList", {specialfilter:"[{\"property\":\"Tasks\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Tasks_MailingListsDiv", t:"Tasks_MailingLists", m:"mtmview", n:"Tasks"}, [{property:"Tasks", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Tasks_MailingListsDiv' class='mtmview innerview'></div>
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
    <div style='clear:left'></div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
