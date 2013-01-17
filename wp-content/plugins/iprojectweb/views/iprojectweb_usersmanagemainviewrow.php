<?php
/**
 * @file
 *
 * 	iProjectWebUsers manageMain view row html function
 *
 * 	@see iProjectWebUsers::getManageMainView()
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
 * 	Displays a iProjectWebUsers manageMain view record
 *
 * @param object $view
 * 	the iProjectWebUsers manageMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getUsersManageMainViewRow($view, $obj, $i, $map) {

		$jsconf = json_decode(stripslashes($map['a']));
		$args = $jsconf->ca[0];
		$obj->addjsconfig = (object) array();
		$obj->addjsconfig->viewTarget = $args->mt . 'Div';
		$obj->addjsconfig->t = $args->mt;
		$obj->addjsconfig->m = 'mtmview';
		$obj->addjsconfig->m2 = 'addRow';
		$obj->addjsconfig->n = $args->t;
		$obj->addjsconfig->a = array();
		$obj->addjsconfig->a[] = (object) array('fld' => $args->n,'oid' => $obj->getId());
		$obj->addjsconfig->a[] = (object) array('fld' => $args->fld,'oid' => $args->oid);
		$obj->addjsconfig->a = json_encode($obj->addjsconfig->a);
		$obj->addjsconfig = iProjectWebUtils::toJs($obj->addjsconfig);
		$obj->Add = "onclick='link($obj->addjsconfig, $view->jsconfig)'";


		$obj->Description = array();
		$obj->Description[] = $obj->get('Name');
		$obj->Description[] = $obj->get('Description');
		$obj->Description = iProjectWebUtils::vImplode(' ', $obj->Description);

  ?>
  <tr>
    <td class='firstcolumn'>
      <a id='<?php echo $obj->elId('Add', $obj->getId());?>' title='<?php echo IPROJECTWEB_Add;?>' href='javascript:;' class='icon_button_add ufo-mtmlink-button' <?php echo $obj->Add;?>></a>
    </td>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a id='<?php echo $obj->elId('Description', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('id');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->Description;?>
      </a>
    </td>
  </tr>
	<?php
}
