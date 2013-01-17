<?php
/**
 * @file
 *
 * 	iProjectWebUserField1 readonly view row html function
 *
 * 	@see iProjectWebUserField1::getReadonlyView()
 * 	@see iProjectWebLayout::getRows()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

/**
 * 	Displays a iProjectWebUserField1 readonly view record
 *
 * @param object $view
 * 	the iProjectWebUserField1 readonly view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getUserField1ReadonlyViewRow($view, $obj, $i, $map) { ?>
  <li>
    <h3>
      <?php echo $obj->get('Description');?>
    </h3>
    <?php echo $obj->get('Notes');?>
  </li>
	<?php
}
