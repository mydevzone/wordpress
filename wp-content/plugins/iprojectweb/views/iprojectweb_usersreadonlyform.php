<?php
/**
 * @file
 *
 * 	iProjectWebUsers readonly form html template
 *
 * 	@see iProjectWebUsers::getReadonlyForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Users', 'Name,Description', '%s %s');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <?php iProjectWebLayout::getTabHeader(array('About', 'ProjectTeamMember'), 'top');?>
    <div class='ufo-tab-wrapper ufo-tab-top'>
      <div id='About' class='ufo-tabs ufo-tab ufo-active'>
        <div style='overflow:auto;height:300px'>
          <div style='float:left;padding:0 10px'>
            <fieldset>
              <legend>
                 <?php echo IPROJECTWEB_ContactData;?>
              </legend>
              <?php if ( !$obj->isEmpty('Cell') ) : ?>
                 <div style='width:100%'>
                   <label><?php echo IPROJECTWEB_Cell;?></label>
                   <?php echo $obj->get('Cell');?>
                 </div>
              <?php endif; ?>
              <?php if ( !$obj->isEmpty('email') ) : ?>
                 <div style='width:100%'>
                   <label><?php echo IPROJECTWEB_email;?></label>
                   <?php echo $obj->get('email');?>
                 </div>
              <?php endif; ?>
              <?php if ( !$obj->isEmpty('SkypeId') ) : ?>
                 <div style='width:100%'>
                   <label><?php echo IPROJECTWEB_SkypeId;?></label>
                   <?php echo $obj->get('SkypeId');?>
                 </div>
              <?php endif; ?>
              <?php if ( !$obj->isEmpty('Phone') ) : ?>
                 <div style='width:100%'>
                   <label><?php echo IPROJECTWEB_Phone;?></label>
                   <?php echo $obj->get('Phone');?>
                 </div>
              <?php endif; ?>
              <?php if ( !$obj->isEmpty('email2') ) : ?>
                 <div style='width:100%'>
                   <label><?php echo IPROJECTWEB_email2;?></label>
                   <?php echo $obj->get('email2');?>
                 </div>
              <?php endif; ?>
            </fieldset>
          </div>
          <?php iProjectWebIHTML::getFileDownloadLink($obj->thumbPhoto);?>
          <div>
            <?php echo $obj->get('About');?>
          </div>
        </div>
      </div>
      <div id='ProjectTeamMember' class='ufo-tabs ufo-tab'>
        <div>
          <input type='hidden' value='AppMan.initRedirect("ProjectTeamMember", {specialfilter:"[{\"property\":\"Members\", \"value\":{\"values\":[<?php echo $obj->get('id');?>]}}]", viewTarget:"Projects_TeamsDiv", t:"Projects_Teams", m:"mtmview", n:"Users"}, [{property:"Members", value:{values:[<?php echo $obj->get('id');?>]}}])' class='ufo-eval'>
          <div id='Projects_TeamsDiv' class='mtmview innerview'></div>
        </div>
      </div>
    </div>
  </div>
  <div>
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
