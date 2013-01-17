<?php
/**
 * @file
 *
 * 	iProjectWebProjectFiles main form html template
 *
 * 	@see iProjectWebProjectFiles::getMainForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'ProjectFiles');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <div>
      <label><?php echo IPROJECTWEB_Description;?></label>
      <input type='text' id='Description' value='<?php echo $obj->get('Description');?>' class='textinput ufo-text ufo-formvalue' style='width:100%'>
    </div>
    <div>
      <div class='ufo-float-left ufo-width50'>
        <div>
          <label for='ObjectOwner'><?php echo IPROJECTWEB_ObjectOwner;?></label>
          <?php iProjectWebIHTML::getAS($obj->ObjectOwner);?>
        </div>
        <div>
          <label for='Date'><?php echo IPROJECTWEB_Date;?></label>
          <div class='ufo-input-wrapper'>
            <input type='text' id='Date' value='<?php echo $obj->Date;?>' READONLY class='ufo-date datebox ufo-internal ufo-formvalue'>
            <a id='Date-Trigger' href='javascript:;' class='ufo-triggerbutton icon_trigger_calendar'>&nbsp;&nbsp;</a>
          </div>
          <input type='hidden' value='setupCalendar("Date", {ifFormat:"<?php echo IPROJECTWEB_DateFormatCalendar;?>", firstDay:0, align:"Bl", singleClick:true});' class='ufo-eval'>
        </div>
      </div>
      <div class='ufo-float-right ufo-width50'>
        <?php if ($obj->ifRole('SuperAdmin')) : ?>
          <div>
            <label for='Projects'><?php echo IPROJECTWEB_Project;?></label>
            <?php iProjectWebIHTML::getAS($obj->Projects);?>
          </div>
        <?php endif; ?>
        <?php if ($obj->ifnRole('SuperAdmin')) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Projects;?></label>
            <a id='Projects' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
              <?php echo $obj->get('ProjectsDescription');?>
            </a>
          </div>
        <?php endif; ?>
      </div>
      <div style='clear:left'></div>
    </div>
    <div>
      <div>
        <label for='Notes' class='ufo-label-top'><?php echo IPROJECTWEB_Notes;?></label>
        <?php if (iProjectWebApplicationSettings::getInstance()->get('UseTinyMCE')) : 
          iProjectWebIHTML::getTinyMCE('Notes');
        endif; ?>
        <textarea id='Notes' class='ufo-formvalue' style='width:100%'><?php echo $obj->get('Notes');?></textarea>
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
      <?php iProjectWebIHTML::getFileUpload('File', $obj->File);?>
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
