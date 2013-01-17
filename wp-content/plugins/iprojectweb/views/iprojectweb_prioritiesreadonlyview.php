<?php
/**
 * @file
 *
 * 	iProjectWebPriorities readonly view html template
 *
 * 	@see iProjectWebPriorities ::getReadonlyView()
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
echo iProjectWebUtils::getViewDescriptionLabel(IPROJECTWEB_Priorities);
iProjectWebLayout::getFormHeader2Body();

?>
  <div>
    <ul class='ufo-kb-readonly'>
      <?php iProjectWebLayout::getRows(
        $resultset,
        'iProjectWebPriorities',
        $obj,
        'iprojectweb_prioritiesreadonlyviewrow.php',
        'getPrioritiesReadonlyViewRow',
        $viewmap
      );?>
    </ul>
  </div><?php

iProjectWebLayout::getFormBodyFooter();
