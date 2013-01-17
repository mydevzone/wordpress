<?php
/**
 * @file
 *
 * 	iProjectWebFiles main view html template
 *
 * 	@see iProjectWebFiles ::getMainView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-mainview ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_Files);
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
            'title' => IPROJECTWEB_Delete,
            'events' => " onclick='mdelete($obj->jsconfig)'",
            'iclass' => " class='icon_button_delete' ",
            'bclass' => "ufo-imagebutton",
          )
        );?>
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
    <div id='divFilesFilter' class='ufo-filter'>
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
            <label for='<?php echo $obj->sId('Doctype');?>'><?php echo IPROJECTWEB_Doctype;?></label>
            <select id='<?php echo $obj->sId('Doctype');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Doctype' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Docfield');?>'><?php echo IPROJECTWEB_Docfield;?></label>
            <select id='<?php echo $obj->sId('Docfield');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Docfield' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Docid');?>'><?php echo IPROJECTWEB_Docid;?></label>
            <select id='<?php echo $obj->sId('Docid');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='Docid' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Name');?>'><?php echo IPROJECTWEB_Name;?></label>
            <select id='<?php echo $obj->sId('Name');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Name' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Type');?>'><?php echo IPROJECTWEB_Type;?></label>
            <select id='<?php echo $obj->sId('Type');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Type' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('Size');?>'><?php echo IPROJECTWEB_Size;?></label>
            <select id='<?php echo $obj->sId('Size');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='Size' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Protected');?>'><?php echo IPROJECTWEB_Protected;?></label>
            <select id='<?php echo $obj->sId('Protected');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('bool');?>
            </select>
            <input type='checkbox' id='Protected' class='ufo-cb checkbox' onchange='this.value=(this.checked)?"on":"off"'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Webdir');?>'><?php echo IPROJECTWEB_Webdir;?></label>
            <select id='<?php echo $obj->sId('Webdir');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('bool');?>
            </select>
            <input type='checkbox' id='Webdir' class='ufo-cb checkbox' onchange='this.value=(this.checked)?"on":"off"'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Count');?>'><?php echo IPROJECTWEB_Count;?></label>
            <select id='<?php echo $obj->sId('Count');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('general');?>
            </select>
            <input type='text' id='Count' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Storagename');?>'><?php echo IPROJECTWEB_Storagename;?></label>
            <select id='<?php echo $obj->sId('Storagename');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='Storagename' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('ObjectOwner');?>'><?php echo IPROJECTWEB_ObjectOwner;?></label>
            <select id='<?php echo $obj->sId('ObjectOwner');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <th style='width:8px'>
            <?php echo IPROJECTWEB_idid;?>
          </th>
          <th style='width:30px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "id"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Doctype"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Docfield"));?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Docid"));?>
          </th>
          <th>
            <div style='width:140px;overflow:auto'>
              <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Name"));?>
            </div>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Size"));?>
          </th>
          <th style='width:50px'>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Webdir"));?>
          </th>
          <th>
            <div style='width:140px;overflow:auto'>
              <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Storagename"));?>
            </div>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "ObjectOwnerDescription",
                 'label' => IPROJECTWEB_ObjectOwner,
              )
            );?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebFiles',
          $obj,
          'iprojectweb_filesmainviewrow.php',
          'getFilesMainViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
