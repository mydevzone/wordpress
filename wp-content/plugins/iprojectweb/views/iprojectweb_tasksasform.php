<?php
/**
 * @file
 *
 * 	iProjectWebTasks AS form html template
 *
 * 	@see iProjectWebTasks::getASForm()
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
  <div class='ufo-as-form ufo-tasks'>
    <div>
      <div class='ufo-as-list-hidden'>
        <?php echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Tasks'); ?>
      </div>
    </div>
    <div>
      <div class='ufo-float-left ufo-width50'>
        <?php if ( !$obj->isEmpty('ProjectsDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Project;?></label>
            <?php echo $obj->get('ProjectsDescription');?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('PriorityDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Priority;?></label>
            <?php echo $obj->get('PriorityDescription');?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('StatusDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Status;?></label>
            <?php echo $obj->get('StatusDescription');?>
          </div>
        <?php endif; ?>
      </div>
      <div class='ufo-float-right ufo-width50'>
        <?php if ( !$obj->isEmpty('TypeDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Type;?></label>
            <?php echo $obj->get('TypeDescription');?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('PlannedDeadline') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Deadline;?></label>
            <?php iProjectWebIHTML::echoDate($obj->get('PlannedDeadline'), IPROJECTWEB_DateFormat, 0);?>
          </div>
        <?php endif; ?>
        <?php if ( !$obj->isEmpty('ObjectOwnerDescription') ) : ?>
          <div>
            <label><?php echo IPROJECTWEB_Responsible;?></label>
            <?php echo $obj->get('ObjectOwnerDescription');?>
          </div>
        <?php endif; ?>
      </div>
      <div style='clear:left'></div>
    </div>
    <?php if ( !$obj->isEmpty('Notes') ) : ?>
      <div class='ufo-as-list-hidden'>
        <label class='ufo-label-top' style='float:none;clear:both'><?php echo IPROJECTWEB_Notes;?></label>
        <?php iProjectWebIHTML::echoStr($obj->get('Notes'), '', 200);?>
      </div>
    <?php endif; ?>
  </div>
