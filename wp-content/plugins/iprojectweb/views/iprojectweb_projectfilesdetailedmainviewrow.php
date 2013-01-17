<?php
/**
 * @file
 *
 * 	iProjectWebProjectFiles detailedMain view row html function
 *
 * 	@see iProjectWebProjectFiles::getDetailedMainView()
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
 * 	Displays a iProjectWebProjectFiles detailedMain view record
 *
 * @param object $view
 * 	the iProjectWebProjectFiles detailedMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getProjectFilesDetailedMainViewRow($view, $obj, $i, $map) {

		$obj->File = array(
				'doctype' => 'ProjectFiles',
				'docid' => $obj->get('id'),
				'field' => 'File',
				'tag' => 'a',
				'content' => IPROJECTWEB_Download,
			);

  ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <?php if ($view->ifRole('SuperAdmin', 'Owner')) : ?>
      <td class='firstcolumn'>
        <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
      </td>
    <?php endif; ?>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"ProjectFiles"})'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <?php iProjectWebIHTML::getFileDownloadLink($obj->File);?>
    </td>
    <td>
      <?php iProjectWebIHTML::echoDate($obj->get('Date'), IPROJECTWEB_DateFormat, 0);?>
    </td>
    <td>
      <a id='<?php echo $obj->elId('ObjectOwner', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ObjectOwnerDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
