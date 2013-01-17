<?php
/**
 * @file
 *
 * 	iProjectWebRisks readonly form html template
 *
 * 	@see iProjectWebRisks::getReadonlyForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Risks');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('GeneralInfo', 'MitigationPlanInfo', 'History', 'RiskMailingList'), 'top');?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='GeneralInfo' class='ufo-tabs ufo-tab ufo-active'>
        <div></div>
        <div>
          <div class='ufo-float-left ufo-width50'>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Type;?></label>
              <?php echo $obj->get('TypeDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Status;?></label>
              <?php echo $obj->get('StatusDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Impact;?></label>
              <?php echo $obj->get('ImpactDescription');?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_ObjectOwner;?></label>
              <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
                 <?php echo $obj->get('ObjectOwnerDescription');?>
              </a>
            </div>
          </div>
          <div class='ufo-float-right ufo-width50'>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_MitigationStrategy;?></label>
              <?php echo $obj->get('MitigationStrategyDescription');?>
            </div>
            <div style='width:100%'>
              <label><?php echo IPROJECTWEB_Probability;?></label>
              <?php echo $obj->get('ProbabilityDescription');?>
            </div>
            <div>
              <label><?php echo IPROJECTWEB_Project;?></label>
              <a id='Projects' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
                 <?php echo $obj->get('ProjectsDescription');?>
              </a>
            </div>
          </div>
          <div style='clear:left'></div>
        </div>
        <div>
          <div>
            <label class='ufo-label-top'><?php echo IPROJECTWEB_RiskDescription;?></label>
            <div class='ufo-y-overflow'>
              <div style='width:100%;height:260px'><?php echo $obj->get('RiskDescription');?></div>
            </div>
          </div>
        </div>
      </div>
      <div id='MitigationPlanInfo' class='ufo-tabs ufo-tab'>
        <div class='ufo-y-overflow'>
          <div style='width:100%;height:420px'><?php echo $obj->get('MitigationPlan');?></div>
        </div>
      </div>
      <div id='History' class='ufo-tabs ufo-tab'>
        <div>
          <label class='ufo-label-top'><?php echo IPROJECTWEB_History;?></label>
          <div class='ufo-y-overflow'>
            <div style='width:100%;height:210px'><?php echo $obj->get('History');?></div>
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
        <input type='hidden' value='AppMan.initRedirect("RiskMailingList", {specialfilter:"[{\"property\":\"Risks\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Risks_MailingListsDiv", t:"Risks_MailingLists", m:"mtmview", n:"Risks"}, [{property:"Risks", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
        <div id='Risks_MailingListsDiv' class='mtmview innerview'></div>
      </div>
    </div>
  </div>
  <div>
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
