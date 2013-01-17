<?php
/**
 * @file
 *
 * 	iProjectWebTasks detailedMain view html template
 *
 * 	@see iProjectWebTasks ::getDetailedMainView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

?>
  <div>
    <div class='buttons'>
      <div class='ufo-float-left'>
        <?php iProjectWebIHTML::getScroller($obj);?>
      </div>
      <?php if ($obj->ifRole('SuperAdmin', 'Owner')) : ?>
        <div class='ufo-float-left'>
          <?php echo iProjectWebIHTML::getButton(
            array(
              'title' => IPROJECTWEB_Delete,
              'events' => " onclick='mdelete($obj->jsconfig)'",
              'iclass' => " class='icon_button_delete' ",
              'bclass' => "ufo-imagebutton",
            )
          );?>
        </div>
      <?php endif; ?>
      <?php if ($obj->ifRole('SuperAdmin', 'Owner')) : ?>
        <div class='ufo-float-left'>
          <?php echo iProjectWebIHTML::getButton(
            array(
              'title' => IPROJECTWEB_Add,
              'events' => " onclick='newObject($obj->jsconfig, this)'",
              'iclass' => " class='icon_button_add' ",
              'bclass' => "ufo-imagebutton",
            )
          );?>
        </div>
      <?php endif; ?>
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
    <div id='divTasksFilter' class='ufo-filter'>
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
            <label for='<?php echo $obj->sId('Priority');?>'><?php echo IPROJECTWEB_Priority;?></label>
            <select id='<?php echo $obj->sId('Priority');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Priority' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'Priorities', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Status');?>'><?php echo IPROJECTWEB_Status;?></label>
            <select id='<?php echo $obj->sId('Status');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Status' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'TaskStatuses', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Type');?>'><?php echo IPROJECTWEB_Type;?></label>
            <select id='<?php echo $obj->sId('Type');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Type' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'TaskTypes', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ObjectOwner');?>'><?php echo IPROJECTWEB_Responsible;?></label>
            <select id='<?php echo $obj->sId('ObjectOwner');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('PlannedDeadline');?>'><?php echo IPROJECTWEB_PlannedDeadline;?></label>
            <select id='<?php echo $obj->sId('PlannedDeadline');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <div class='ufo-input-wrapper' style='width:108px'>
              <input type='text' id='PlannedDeadline' READONLY class='ufo-date datebox ufo-internal ufo-filtervalue'>
              <a id='PlannedDeadline-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
            </div>
            <input type='hidden' value='setupCalendar("PlannedDeadline", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('PlannedEffort');?>'><?php echo IPROJECTWEB_PlannedEffort;?></label>
            <select id='<?php echo $obj->sId('PlannedEffort');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='PlannedEffort' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ActualDeadline');?>'><?php echo IPROJECTWEB_ActualDeadline;?></label>
            <select id='<?php echo $obj->sId('ActualDeadline');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <div class='ufo-input-wrapper' style='width:108px'>
              <input type='text' id='ActualDeadline' READONLY class='ufo-date datebox ufo-internal ufo-filtervalue'>
              <a id='ActualDeadline-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
            </div>
            <input type='hidden' value='setupCalendar("ActualDeadline", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ActualEffort');?>'><?php echo IPROJECTWEB_ActualEffort;?></label>
            <select id='<?php echo $obj->sId('ActualEffort');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='ActualEffort' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Notes');?>'><?php echo IPROJECTWEB_Notes;?></label>
            <select id='<?php echo $obj->sId('Notes');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Notes' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('History');?>'><?php echo IPROJECTWEB_History;?></label>
            <select id='<?php echo $obj->sId('History');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='History' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <?php if ($obj->ifRole('SuperAdmin', 'Owner')) : ?>
            <th style='width:8px'>
              <?php echo IPROJECTWEB_idid;?>
            </th>
          <?php endif; ?>
          <th style='width:30px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "id"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Description"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "PriorityListPosition",
                 'label' => IPROJECTWEB_Priority,
              )
            );?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "PlannedDeadline",
                 'label' => IPROJECTWEB_Deadline,
              )
            );?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "PlannedEffort",
                 'label' => IPROJECTWEB_Effort,
              )
            );?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebTasks',
          $obj,
          'iprojectweb_tasksdetailedmainviewrow.php',
          'getTasksDetailedMainViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div>
