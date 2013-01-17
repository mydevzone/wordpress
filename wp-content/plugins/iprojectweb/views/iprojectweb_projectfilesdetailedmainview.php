<?php
/**
 * @file
 *
 * 	iProjectWebProjectFiles detailedMain view html template
 *
 * 	@see iProjectWebProjectFiles ::getDetailedMainView()
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
    <div id='divProjectFilesFilter' class='ufo-filter'>
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
            <label for='<?php echo $obj->sId('Date');?>'><?php echo IPROJECTWEB_Date;?></label>
            <select id='<?php echo $obj->sId('Date');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <div class='ufo-input-wrapper' style='width:108px'>
              <input type='text' id='Date' READONLY class='ufo-date datebox ufo-internal ufo-filtervalue'>
              <a id='Date-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
            </div>
            <input type='hidden' value='setupCalendar("Date", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('ObjectOwner');?>'><?php echo IPROJECTWEB_ObjectOwner;?></label>
            <select id='<?php echo $obj->sId('ObjectOwner');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Notes');?>'><?php echo IPROJECTWEB_Notes;?></label>
            <select id='<?php echo $obj->sId('Notes');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Notes' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
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
            <?php echo IPROJECTWEB_File;?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Date"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "ObjectOwnerDescription",
                 'label' => IPROJECTWEB_Submitter,
              )
            );?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebProjectFiles',
          $obj,
          'iprojectweb_projectfilesdetailedmainviewrow.php',
          'getProjectFilesDetailedMainViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div>
