<!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
<style>       
 .dropdown-menu {
  color: black;
  padding: 5px;
  background-color: #fff;
  font-size: 16px;
  border: none;

}

.dropdown {
  position: relative;
  display: inline-block;
  /* padding: -8rem !important; */
  left: -70px;
}

.dropdown-menu {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 300px;
  margin-left: -8rem !important;
  box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-menu a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
 
}

.dropdown-menu a:hover {background-color: #ddd;}
.nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .sidebar-nav ul {
    margin: 0px;
    padding: 6px;
    right: 92px;
    left: 100px;
}
.dropdown .nav-links
{
    font-size: 1rem;
    margin-left: 0rem;
    padding: 8px;
}

.scroll-sidebar
{
    max-width: 90% !important;
   margin-left: 100px;
}
.nav-link {
    display: block;
    padding: 0.1rem 3rem;
}

        </style>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                <!-- <nav class="navbar navbar-expand-lg navbar-light"> -->
                    <div class="container-fluid">
                        <?php $roleid = $user->role_id;?>
                    <?php foreach($shop_menus as $menu):?>
                     <?php $rs =  $this->admin_model->get_submenu_data($menu->id,$roleid);
                      $menu_flag ='0';
                     foreach($rs as $all) 
                     {
                     
                      if($menu->id == $all->parent)
                      {
                          $menu_flag ='1';
                          break;
                      }
                    }
                      if($menu_flag == '1')
                      {
                          $url = $menu->url.'/'.$menu->id;
                      }
                      else if($menu_flag == '0')
                      {
                          $url = $menu->url;
                      }
                      
                       ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-links dropdown-toggle" href="<?=base_url($url);?>" id="navbarDropdown<?= str_replace(' ', '', $menu->title) ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="<?= $menu->icon_class; ?>"></i>  <?= $menu->title; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown<?= str_replace(' ', '', $menu->title) ?>">
                                    <?php foreach($rs as $r): ?>
                                        <li><a class="dropdown-item" href="<?php echo base_url($r->url.'/'.$r->id); ?>"><?= $r->title ?></a></li>
                                       
                                    <?php endforeach; ?>
                                </ul>
                             
                            </li>
                        <?php endforeach; ?>
                        
                    </div>
                </nav>
                    <!-- <ul id="sidebarnav">
                        
                    <?php /* foreach($shop_menus as $menu)
                    { 
                        foreach($all_menus as $all) 
                        {
                            $menu_flag ='0';
                            if($menu->id == $all->parent)
                            {
                                $menu_flag ='1';
                                break;
                            }
                        }
                        if($menu_flag == '1')
                        {
                            $url = $menu->url.'/'.$menu->id;
                        }
                        else if($menu_flag == '0')
                        {
                            $url = $menu->url;
                        } 
                    ?>
                        <li>
                            <a href="<?php echo base_url($url); ?>"><i class="<?= $menu->icon_class; ?>"></i><span class="hide-menu"><?= $menu->title; ?></span></a>
                        </li>
                    <?php  }*/ ?>
                    </ul> -->
                <!-- </nav> -->
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->