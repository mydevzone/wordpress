<?php
/**
 * @file
 *
 * 	iProjectWebProjectField1 readonly view html template
 *
 * 	@see iProjectWebProjectField1 ::getReadonlyView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */


iProjectWebLayout::getFormHeader('ufo-readonly-view ufo-readonlyview ufo-' . strtolower($obj->type));
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_ProjectField1);
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <ul class='ufo-kb-readonly'>
      <?php iProjectWebLayout::getRows(
        $resultset,
        'iProjectWebProjectField1',
        $obj,
        'iprojectweb_projectfield1readonlyviewrow.php',
        'getProjectField1ReadonlyViewRow',
        $viewmap
      );?>
    </ul>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
