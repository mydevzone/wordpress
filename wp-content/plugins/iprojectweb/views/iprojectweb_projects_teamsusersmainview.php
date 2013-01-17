<?php
/**
 * @file
 *
 * 	iProjectWebProjects_Teams UsersMain view html template
 *
 * 	@see iProjectWebProjects_Teams ::getUsersMainView()
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
  <div>
    <div class='buttons'>
      <div class='ufo-float-left'>
        <?php iProjectWebIHTML::getScroller($obj);?>
      </div>
      <div class='ufo-float-left'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'title' => IPROJECTWEB_Delete,
            'events' => " onclick='mtmdelete($obj->jsconfig)'",
            'iclass' => " class='icon_button_delete' ",
            'bclass' => "ufo-imagebutton",
          )
        );?>
      </div>
      <div class='ufo-float-left'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'title' => IPROJECTWEB_Search,
            'events' => " onclick='doFilter($obj->jsconfig, this)'",
            'iclass' => " class='icon_filter' ",
            'bclass' => "ufo-imagebutton",
          )
        );?>
      </div>
      <div style='clear:left'></div>
    </div>
  </div>
  <div>
    <div id='divProjects_TeamsFilter' class='ufo-filter'>
      <div class='ufofilterbutton'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'label' => IPROJECTWEB_Filter,
            'events' => " onclick='filter($obj->jsconfig);'",
            'iclass' => " class='icon_filter_pane' ",
            'bclass' => "button internalimage",
          )
        );?>
      </div>
      <div class='ufo-clear-both'></div>
      <div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('Projects');?>'><?php echo IPROJECTWEB_Project;?></label>
            <select id='<?php echo $obj->sId('Projects');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->Projects);?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <th style='width:8px'>
            <?php echo IPROJECTWEB_idid;?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "ProjectsDescription",
                 'label' => IPROJECTWEB_Project,
              )
            );?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(array('view' => $obj, 'field' => "Role"));?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebProjects_Teams',
          $obj,
          'iprojectweb_projects_teamsusersmainviewrow.php',
          'getProjects_TeamsUsersMainViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div>
