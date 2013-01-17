<?php
/**
 * @file
 *
 * 	iProjectWebProjects PM view html template
 *
 * 	@see iProjectWebProjects ::getPMView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-pmview ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_Projects);
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <div class='buttons'>
      <div class='ufo-float-left'>
        <?php iProjectWebIHTML::getScroller($obj);?>
      </div>
      <div class='ufo-float-left'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'title' => IPROJECTWEB_Search,
            'events' => " onclick='doFilter($obj->jsconfig, this)'",
            'iclass' => " class='icon_filter' ",
            'bclass' => "ufo-imagebutton",
          )
        );?>
      </div>
      <div style='clear:left'></div>
    </div>
  </div>
  <div>
    <div id='divProjectsFilter' class='ufo-filter'>
      <div class='ufofilterbutton'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'label' => IPROJECTWEB_Filter,
            'events' => " onclick='filter($obj->jsconfig);'",
            'iclass' => " class='icon_filter_pane' ",
            'bclass' => "button internalimage",
          )
        );?>
      </div>
      <div class='ufo-clear-both'></div>
      <div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('id');?>'><?php echo IPROJECTWEB_id;?></label>
            <select id='<?php echo $obj->sId('id');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='id' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Description');?>'><?php echo IPROJECTWEB_Description;?></label>
            <select id='<?php echo $obj->sId('Description');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Description' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Status');?>'><?php echo IPROJECTWEB_Status;?></label>
            <select id='<?php echo $obj->sId('Status');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Status' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'ProjectStatuses', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('StartDate');?>'><?php echo IPROJECTWEB_StartDate;?></label>
            <select id='<?php echo $obj->sId('StartDate');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <div class='ufo-input-wrapper' style='width:108px'>
              <input type='text' id='StartDate' READONLY class='ufo-date datebox ufo-internal ufo-filtervalue'>
              <a id='StartDate-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
            </div>
            <input type='hidden' value='setupCalendar("StartDate", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('FinishDate');?>'><?php echo IPROJECTWEB_FinishDate;?></label>
            <select id='<?php echo $obj->sId('FinishDate');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <div class='ufo-input-wrapper' style='width:108px'>
              <input type='text' id='FinishDate' READONLY class='ufo-date datebox ufo-internal ufo-filtervalue'>
              <a id='FinishDate-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
            </div>
            <input type='hidden' value='setupCalendar("FinishDate", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('ProjectDescription');?>'><?php echo IPROJECTWEB_ProjectDescription;?></label>
            <select id='<?php echo $obj->sId('ProjectDescription');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='ProjectDescription' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('History');?>'><?php echo IPROJECTWEB_History;?></label>
            <select id='<?php echo $obj->sId('History');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='History' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ProjectField3');?>'><?php echo IPROJECTWEB_ProjectField3;?></label>
            <select id='<?php echo $obj->sId('ProjectField3');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='ProjectField3' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ProjectField4');?>'><?php echo IPROJECTWEB_ProjectField4;?></label>
            <select id='<?php echo $obj->sId('ProjectField4');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='ProjectField4' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('userid');?>'><?php echo IPROJECTWEB_ProjectField4;?></label>
            <select id='<?php echo $obj->sId('userid');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string', FALSE);?>
            </select>
            <input type='text' id='userid' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <th style='width:30px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "id"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Description"));?>
          </th>
          <th style='width:70px'>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "StatusListPosition",
                 'label' => IPROJECTWEB_Status,
              )
            );?>
          </th>
          <th style='width:60px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "StartDate"));?>
          </th>
          <th style='width:60px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "FinishDate"));?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebProjects',
          $obj,
          'iprojectweb_projectspmviewrow.php',
          'getProjectsPMViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
