<?php
/**
 * @file
 *
 * 	iProjectWebRisks main form html template
 *
 * 	@see iProjectWebRisks::getMainForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Risks');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('GeneralInfo', 'MitigationPlanInfo', 'History', 'RiskMailingList'), 'top');?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div>
          <label><?php echo IPROJECTWEB_Title;?></label>
          <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
        </div>
        <div>
          <div class='ufo-float-left ufo-width50'>
            <div>
              <label for='Type'><?php echo IPROJECTWEB_Type;?></label>
              <select id='Type' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Type', TRUE, 'RiskTypes', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='Status'><?php echo IPROJECTWEB_Status;?></label>
              <select id='Status' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Status', TRUE, 'RiskStatuses', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='Impact'><?php echo IPROJECTWEB_Impact;?></label>
              <select id='Impact' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Impact', TRUE, 'RiskImpacts', 'ListPosition');?>
              </select>
            </div>
            <?php if ($obj->ifRole('SuperAdmin', 'Owner')) : ?>
              <div>
                 <label for='ObjectOwner'><?php echo IPROJECTWEB_ObjectOwner;?></label>
                 <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
              </div>
            <?php endif; ?>
            <?php if ($obj->ifnRole('SuperAdmin', 'Owner')) : ?>
              <div>
                 <label><?php echo IPROJECTWEB_ObjectOwner;?></label>
                 <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                   <?php echo $obj->get('ObjectOwnerDescription');?>
                 </a>
              </div>
            <?php endif; ?>
          </div>
          <div class='ufo-float-right ufo-width50'>
            <div>
              <label for='MitigationStrategy'><?php echo IPROJECTWEB_MitigationStrategy;?></label>
              <select id='MitigationStrategy' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'MitigationStrategy', TRUE, 'RiskStrategies');?>
              </select>
            </div>
            <div>
              <label for='Probability'><?php echo IPROJECTWEB_Probability;?></label>
              <select id='Probability' class='inputselect ufo-select ufo-formvalue' style='width:100%'>
                 <?php echo $obj->getListHTML(NULL, 'Probability', TRUE, 'RiskProbabilities', 'ListPosition');?>
              </select>
            </div>
            <div>
              <label for='Projects'><?php echo IPROJECTWEB_Project;?></label>
              <?php iProjectWebIHTML::getAS($obj->Projects);?>
            </div>
          </div>
          <div style='clear:left'></div>
        </div>
        <div>
          <div>
            <label for='RiskDescription' class='ufo-label-top'><?php echo IPROJECTWEB_RiskDescription;?></label>
            <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
              iProjectWebIHTML::getTinyMCE('RiskDescription');
            endif; ?>
            <textarea id='RiskDescription' class='ufo-formvalue' style='width:100%;height:240px'><?php echo $obj->get('RiskDescription');?></textarea>
          </div>
        </div>
      </div>
      <div id='MitigationPlanInfo' class='ufo-tabs ufo-tab'>
        <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
          iProjectWebIHTML::getTinyMCE('MitigationPlan');
        endif; ?>
        <textarea id='MitigationPlan' class='ufo-formvalue' style='width:100%;height:460px'><?php echo $obj->get('MitigationPlan');?></textarea>
      </div>
      <div id='History' class='ufo-tabs ufo-tab'>
        <div>
          <label class='ufo-label-top'><?php echo IPROJECTWEB_History;?></label>
          <div class='ufo-y-overflow'>
            <div style='width:100%;height:260px'><?php echo $obj->get('History');?></div>
          </div>
        </div>
        <div>
          <label for='Comment' class='ufo-label-top'><?php echo IPROJECTWEB_Comment;?></label>
          <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
            iProjectWebIHTML::getTinyMCE('Comment');
          endif; ?>
          <textarea id='Comment' class='ufo-formvalue' style='width:100%;height:150px'><?php echo $obj->get('Comment');?></textarea>
        </div>
      </div>
      <div id='RiskMailingList' class='ufo-tabs ufo-tab'>
        <input type='hidden' value='AppMan.initRedirect("RiskMailingList", {viewTarget:"UsersDiv", t:"Users", m:"mtmview", n:"manage", a:"{\"m\":\"mtmview\", \"ca\":[{\"mt\":\"Risks_MailingLists\", \"oid\":\"<?php echo $obj->get('id');?>\", \"fld\":\"Risks\", \"t\":\"Risks\", \"n\":\"Contacts\"}]}"})' class='ufo-eval'>
        <div id='UsersDiv' class='mtmview innerview' style='width:270px;float:right'></div>
        <input type='hidden' value='AppMan.initRedirect("RiskMailingList", {specialfilter:"[{\"property\":\"Risks\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Risks_MailingListsDiv", t:"Risks_MailingLists", m:"mtmview", n:"Risks"}, [{property:"Risks", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Risks_MailingListsDiv' class='mtmview innerview' style='margin-right:275px'></div>
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
