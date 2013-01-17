<?php
/**
 * @file
 *
 * 	iProjectWebRisks main view html template
 *
 * 	@see iProjectWebRisks ::getMainView()
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
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_Risks);
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
            'title' => IPROJECTWEB_Add,
            'events' => " onclick='newObject($obj->jsconfig, this)'",
            'iclass' => " class='icon_button_add' ",
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
    <div id='divRisksFilter' class='ufo-filter'>
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
            <label for='<?php echo $obj->sId('Type');?>'><?php echo IPROJECTWEB_Type;?></label>
            <select id='<?php echo $obj->sId('Type');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Type' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'RiskTypes', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Status');?>'><?php echo IPROJECTWEB_Status;?></label>
            <select id='<?php echo $obj->sId('Status');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Status' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'RiskStatuses', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Impact');?>'><?php echo IPROJECTWEB_Impact;?></label>
            <select id='<?php echo $obj->sId('Impact');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Impact' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'RiskImpacts', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('MitigationStrategy');?>'><?php echo IPROJECTWEB_MitigationStrategy;?></label>
            <select id='<?php echo $obj->sId('MitigationStrategy');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='MitigationStrategy' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'RiskStrategies');?>
            </select>
          </div>
        </div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('Probability');?>'><?php echo IPROJECTWEB_Probability;?></label>
            <select id='<?php echo $obj->sId('Probability');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Probability' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'RiskProbabilities', 'ListPosition');?>
            </select>
          </div>
          <div>
            <label for='<?php echo $obj->sId('RiskDescription');?>'><?php echo IPROJECTWEB_RiskDescription;?></label>
            <select id='<?php echo $obj->sId('RiskDescription');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='RiskDescription' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('MitigationPlan');?>'><?php echo IPROJECTWEB_MitigationPlan;?></label>
            <select id='<?php echo $obj->sId('MitigationPlan');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='MitigationPlan' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('History');?>'><?php echo IPROJECTWEB_History;?></label>
            <select id='<?php echo $obj->sId('History');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('string');?>
            </select>
            <input type='text' id='History' class='textinput ufo-text ufo-filtervalue' style='width:130px'>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Projects');?>'><?php echo IPROJECTWEB_Project;?></label>
            <select id='<?php echo $obj->sId('Projects');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->Projects);?>
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
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Description"));?>
          </th>
          <th style='width:60px'>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "StatusListPosition",
                 'label' => IPROJECTWEB_Status,
              )
            );?>
          </th>
          <th style='width:80px'>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "TypeListPosition",
                 'label' => IPROJECTWEB_Type,
              )
            );?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "ProjectsDescription",
                 'label' => IPROJECTWEB_Project,
              )
            );?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebRisks',
          $obj,
          'iprojectweb_risksmainviewrow.php',
          'getRisksMainViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
