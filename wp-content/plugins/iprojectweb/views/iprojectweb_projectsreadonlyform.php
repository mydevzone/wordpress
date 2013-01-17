<?php
/**
 * @file
 *
 * 	iProjectWebProjects readonly form html template
 *
 * 	@see iProjectWebProjects::getReadonlyForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Projects');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php
    iProjectWebLayout::getTabHeader(
      array(
        'GeneralInfo',
        'History',
        'ProjectTeam',
        'ProjectMailingList',
        'ProjectFiles',
        'Tasks',
        'Risks',
      ),
    'left')
    ?>
    <div class='ufo-tab-wrapper ufo-tab-left'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div>
          <div class='ufo-float-left ufo-width50'>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Status;?></label>
              <?php echo $obj->get('StatusDescription');?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_StartDate;?></label>
              <?php iProjectWebIHTML::echoDate($obj->get('StartDate'), IPROJECTWEB_DateFormat, 0);?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_FinishDate;?></label>
              <?php iProjectWebIHTML::echoDate($obj->get('FinishDate'), IPROJECTWEB_DateFormat, 0);?>
            </div>
          </div>
          <div class='ufo-float-right ufo-width50'>
            <div>
              <label><?php echo IPROJECTWEB_Manager;?></label>
              <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                 <?php echo $obj->get('ObjectOwnerDescription');?>
              </a>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_ProjectField1;?></label>
              <?php echo $obj->get('ProjectField1Description');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_ProjectField2;?></label>
              <?php echo $obj->get('ProjectField2Description');?>
            </div>
          </div>
          <div style='clear:left'></div>
        </div>
        <div>
          <div>
            <label class='ufo-label-top'><?php echo IPROJECTWEB_ProjectDescription;?></label>
            <div class='ufo-y-overflow'>
              <div style='width:100%;height:260px'><?php echo $obj->get('ProjectDescription');?></div>
            </div>
          </div>
        </div>
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
      <div id='ProjectTeam' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectTeam", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_TeamsDiv", t:"Projects_Teams", m:"mtmview", n:"Projects"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Projects_TeamsDiv' class='mtmview innerview'></div>
      </div>
      <div id='ProjectMailingList' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectMailingList", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_MailingListsDiv", t:"Projects_MailingLists", m:"mtmview", n:"Projects"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Projects_MailingListsDiv' class='mtmview innerview'></div>
      </div>
      <div id='ProjectFiles' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("ProjectFiles", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"ProjectFilesDiv", t:"ProjectFiles", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='ProjectFilesDiv' class='innerview'></div>
      </div>
      <div id='Tasks' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("Tasks", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"TasksDiv", t:"Tasks", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='TasksDiv' class='innerview'></div>
      </div>
      <div id='Risks' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("Risks", {specialfilter:"[{\"property\":\"Projects\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"RisksDiv", t:"Risks", m:"viewDetailed"}, [{property:"Projects", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='RisksDiv' class='innerview'></div>
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
