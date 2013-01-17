<?php
/**
 * @file
 *
 * 	iProjectWebUsers AS form html template
 *
 * 	@see iProjectWebUsers::getASForm()
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
  <div class='ufo-as-form ufo-users'>
    <div class='ufo-as-list-hidden'>
      <?php echo iProjectWebUtils::getTypeFormDescription($obj->getId(), 'Users', 'Name,Description'); ?>
    </div>
    <?php iProjectWebIHTML::getFileDownloadLink($obj->thumbPhoto);?>
    <div>
      <?php if ( !$obj->isEmpty('UserTypeDescription') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_UserType;?></label>
          <?php echo $obj->get('UserTypeDescription');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('RoleDescription') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_Role;?></label>
          <?php echo $obj->get('RoleDescription');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('Cell') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_Cell;?></label>
          <?php echo $obj->get('Cell');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('Phone') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_Phone;?></label>
          <?php echo $obj->get('Phone');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('UserField1Description') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_UserField1;?></label>
          <?php echo $obj->get('UserField1Description');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('Birthday') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_Birthday;?></label>
          <?php iProjectWebIHTML::echoDate($obj->get('Birthday'), IPROJECTWEB_DateFormat, 0);?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('email') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_email;?></label>
          <?php echo $obj->get('email');?>
        </div>
      <?php endif; ?>
      <?php if ( !$obj->isEmpty('UserField2Description') ) : ?>
        <div>
          <label><?php echo IPROJECTWEB_UserField2;?></label>
          <?php echo $obj->get('UserField2Description');?>
        </div>
      <?php endif; ?>
    </div>
    <div class='ufo-as-list-hidden'>
      <label class='ufo-label-top'><?php echo IPROJECTWEB_About;?></label>
      <?php iProjectWebIHTML::echoStr($obj->get('About'), '', 170);?>
    </div>
  </div>
