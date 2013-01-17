<?php
/**
 * @file
 *
 * 	iProjectWebUsers readonly view html template
 *
 * 	@see iProjectWebUsers ::getReadonlyView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-readonlyview ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_Users);
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
    <div id='divUsersFilter' class='ufo-filter'>
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
            <label for='<?php echo $obj->sId('Description');?>'><?php echo IPROJECTWEB_LastName;?></label>
            <select id='<?php echo $obj->sId('Description');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Description' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Name');?>'><?php echo IPROJECTWEB_FirstName;?></label>
            <select id='<?php echo $obj->sId('Name');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Name' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('UserField3');?>'><?php echo IPROJECTWEB_UserField3;?></label>
            <select id='<?php echo $obj->sId('UserField3');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='UserField3' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('UserField4');?>'><?php echo IPROJECTWEB_UserField4;?></label>
            <select id='<?php echo $obj->sId('UserField4');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='UserField4' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "Description",
                 'label' => IPROJECTWEB_Name,
              )
            );?>
          </th>
          <th style='width:220px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "email"));?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebUsers',
          $obj,
          'iprojectweb_usersreadonlyviewrow.php',
          'getUsersReadonlyViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
