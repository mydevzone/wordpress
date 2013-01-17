<?php
/**
 * @file
 *
 * 	iProjectWebProjects AS form html template
 *
 * 	@see iProjectWebProjects::getASForm()
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
  <div class='ufo-as-form ufo-projects'>
    <div>
      <div class='ufo-as-list-hidden'>
        <?php echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Projects'); ?>
      </div>
    </div>
    <div>
      <div class='ufo-float-left ufo-width50'>
        <?php if ( !$obj->isEmpty('StatusDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Status;?></label>
            <?php echo $obj->get('StatusDescription');?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('ObjectOwnerDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Manager;?></label>
            <?php echo $obj->get('ObjectOwnerDescription');?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('ProjectField1Description') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_ProjectField1;?></label>
            <?php echo $obj->get('ProjectField1Description');?>
          </div>
        <?php endif; ?>
      </div>
      <div class='ufo-float-right ufo-width50'>
        <?php if ( !$obj->isEmpty('StartDate') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_StartDate;?></label>
            <?php iProjectWebIHTML::echoDate($obj->get('StartDate'), IPROJECTWEB_DateFormat, 0);?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('FinishDate') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_FinishDate;?></label>
            <?php iProjectWebIHTML::echoDate($obj->get('FinishDate'), IPROJECTWEB_DateFormat, 0);?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('ProjectField2Description') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_ProjectField2;?></label>
            <?php echo $obj->get('ProjectField2Description');?>
          </div>
        <?php endif; ?>
      </div>
      <div style='clear:left'></div>
    </div>
    <?php if ( !$obj->isEmpty('ProjectDescription') ) : ?>
      <div class='ufo-as-list-hidden'>
        <label class='ufo-label-top' style='width:auto;clear:both;float:none'><?php echo IPROJECTWEB_ProjectDescription;?></label>
        <?php iProjectWebIHTML::echoStr($obj->get('ProjectDescription'), '', 200);?>
      </div>
    <?php endif; ?>
  </div>
