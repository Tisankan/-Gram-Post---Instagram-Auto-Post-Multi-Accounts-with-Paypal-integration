<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- Menu -->
        <div class="user-info">
            <div class="image">
                <img src="<?=BASE?>assets/images/user.png" width="48" height="48" alt="User">
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=l('Hi')?>, <?=FULLNAME_USER?></div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?=url('profile')?>" class=" waves-effect waves-block"><i class="material-icons">account_box</i><?=l('Update')?></a></li>
                        <li><a href="<?=url('logout')?>" class=" waves-effect waves-block"><i class="material-icons">lock_open</i><?=l('Logout')?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu">
            <ul class="list">
                <li class="header"><?=l('MAIN NAVIGATION')?></li>
                <?php if(permission("post")){?>
                <li class="<?=(segment(1) == "post")?"active":""?>">
                    <a href="<?=url('post')?>">
                        <i class="material-icons">send</i>
                        <span><?=l('Add new')?></span>
                    </a>
                </li>
                <?php }?>
                <li class="<?=(segment(1) == "schedules")?"active":""?>">
                    <a href="<?=url('schedules/post')?>">
                        <i class="material-icons">assignment</i>
                        <span><?=l('Schedule post')?></span>
                    </a>
                </li>
                <li class="<?=(segment(1) == "dashboard")?"active":""?>">
                    <a href="<?=url('dashboard')?>">
                        <i class="material-icons">assessment</i>
                        <span><?=l('Schedule report')?></span>
                    </a>
                </li>
                <li class="<?=(segment(1) == "instagram_accounts")?"active":""?>">
                    <a href="<?=url('instagram_accounts')?>">
                        <i class="fa fa-instagram fix-iconfa-sidebar" aria-hidden="true"></i>
                        <span><?=l('Instagram accounts')?></span>
                    </a>
                </li>
                <li class="<?=(segment(1) == "save")?"active":""?>">
                    <a href="<?=url('save')?>">
                        <i class="fa fa-floppy-o fix-iconfa-sidebar" aria-hidden="true"></i>
                        <span><?=l('Save post')?></span>
                    </a>
                </li>
                <?php if(IS_ADMIN == 1){?>
                <li class="header"><?=l('ADMIN AREA')?></li>
                <li class="<?=(segment(1) == "user_management")?"active":""?>">
                    <a href="<?=url('user_management')?>">
                        <i class="fa fa-user fix-iconfa-sidebar" aria-hidden="true"></i>
                        <span><?=l('User management')?></span>
                    </a>
                </li>
                <li class="<?=(segment(1) == "settings")?"active":""?>">
                    <a href="<?=url('settings')?>">
                        <i class="fa fa-cogs fix-iconfa-sidebar" aria-hidden="true"></i>
                        <span><?=l('Settings')?></span>
                    </a>
                </li>
                <?php }?>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 <a href="javascript:void(0);"><?=l('VT Creators Team')?></a>.
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>