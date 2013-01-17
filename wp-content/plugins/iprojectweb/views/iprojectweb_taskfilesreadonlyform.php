<?php
/**
 * @file
 *
 * 	iProjectWebTaskFiles readonly form html template
 *
 * 	@see iProjectWebTaskFiles::getReadonlyForm()
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
echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'TaskFiles');
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <div></div>
    <div>
      <div class='ufo-float-left ufo-width50'>
        <div>
          <label><?php echo IPROJECTWEB_Date;?></label>
          <?php iProjectWebIHTML::echoDate($obj->get('Date'), IPROJECTWEB_DateFormat, 0);?>
        </div>
        <div>
          <label><?php echo IPROJECTWEB_ObjectOwner;?></label>
          <a id='ObjectOwner' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
            <?php echo $obj->get('ObjectOwnerDescription');?>
          </a>
        </div>
      </div>
      <div class='ufo-float-right ufo-width50'>
        <div>
          <?php iProjectWebIHTML::getFileDownloadLink($obj->File);?>
        </div>
        <div>
          <label><?php echo IPROJECTWEB_Task;?></label>
          <?php echo $obj->get('TasksDescription');?>
        </div>
      </div>
      <div style='clear:left'></div>
    </div>
    <div>
      <div>
        <label class='ufo-label-top'><?php echo IPROJECTWEB_Notes;?></label>
        <div class='ufo-y-overflow'>
          <div style='width:100%'><?php echo $obj->get('Notes');?></div>
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
