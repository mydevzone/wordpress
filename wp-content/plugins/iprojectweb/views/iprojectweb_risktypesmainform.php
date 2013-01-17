<?php
/**
 * @file
 *
 * 	iProjectWebRiskTypes main form html template
 *
 * 	@see iProjectWebRiskTypes::getMainForm()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-formpage ufo-simple ufo-mainform ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'RiskTypes');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <div>
      <label><?php echo IPROJECTWEB_Description;?></label>
      <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
    </div>
    <div>
      <label for='Notes' class='ufo-label-top'><?php echo IPROJECTWEB_Notes;?></label>
      <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
        iProjectWebIHTML::getTinyMCE('Notes');
      endif; ?>
      <textarea id='Notes' class='ufo-formvalue' style='width:100%'><?php echo $obj->get('Notes');?></textarea>
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
