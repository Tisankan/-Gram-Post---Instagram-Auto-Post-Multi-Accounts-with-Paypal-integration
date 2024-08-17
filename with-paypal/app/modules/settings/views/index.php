<form action="<?=cn()?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="fa fa-cogs" aria-hidden="true"></i> <?=l('Settings')?> 
                    </h2>
                </div>
                <div class="body pt0">
                    <div class="row">
                        <div class="col-sm-12 mb0">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#home_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">home</i> <?=l('GENARAL')?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#profile_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">send</i> <?=l('POST & SCHEDULE')?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#messages_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">share</i> <?=l('LOGIN SOCIAL')?>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#messages_with_icon_title2" data-toggle="tab">
                                        <i class="material-icons">loyalty</i> <?=l('LINK SOCIAL PAGE')?>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                                    <b><?=l('Website name')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" class="form-control" name="token" id="token" value="<?=$this->security->get_csrf_hash();?>">
                                            <input type="text" class="form-control" name="website_title" value="<?=!empty($result)?$result->website_title:""?>">
                                        </div>
                                    </div>
                                    <b><?=l('Website description')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="website_description" value="<?=!empty($result)?$result->website_description:""?>">
                                        </div>
                                    </div>
                                    <b><?=l('Website keywords')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="website_keyword" value="<?=!empty($result)?$result->website_keyword:""?>">
                                        </div>
                                    </div>
                                    <b><?=l('Website logo')?></b>
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="file" value="<?=!empty($result)?$result->logo:""?>">
                                    </div>
                                    <b><?=l('Theme color')?></b>
                                    <div class="form-group">
                                        <select name="theme_color" class="form-control">
                                        <?php foreach(theme_color() as $key => $color) { ?>
                                            <option value="<?=$key?>" <?=(!empty($result) && $result->theme_color == $key)?"selected":""?>>
                                                <?=$color?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <b><?=l('Timezone server')?></b>
                                    <div class="form-group">
                                        <select name="timezone" class="form-control">
                                        <?php foreach(tz_list() as $t) { ?>
                                            <option value="<?=$t['zone'] ?>" <?=(!empty($result) && $result->timezone == $t['zone'])?"selected":""?>>
                                                <?=$t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <b><?=l('Default language')?></b>
                                    <div class="form-group">
                                        <select class="form-control" name="default_language">
                                            <?php if(!empty($lang))
                                            foreach ($lang as $row) {
                                            ?>
                                            <option value="<?=$row?>" <?=(!empty($result) && $result->default_language == $row)?"selected":""?>><?=strtoupper($row)?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <b><?=l('Add new language')?></b>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="language" id="language">
                                            <span class="input-group-btn">
                                              <a href="<?=BASE?>lang/en.xml" target="_blank" class="btn bg-red waves-effect"><i class="fa fa-info-circle"></i> <?=l('View demo')?></a>
                                            </span>
                                        </div>
                                    </div>
                                    <b><?=l('Register user')?></b>
                                    <div class="form-group demo-radio-button">
                                        <input name="register" type="radio" id="register_yes" class="radio-col-red" <?=(!empty($result) && $result->register == 1)?"checked=''":""?> value="1">
                                        <label for="register_yes"><?=l('Yes')?></label>

                                        <input name="register" type="radio" id="register_no" class="radio-col-red" <?=(!empty($result) && $result->register == 0)?"checked=''":""?> value="0">
                                        <label for="register_no"><?=l('No')?></label>
                                    </div>
                                    <b><?=l('Auto active user')?></b>
                                    <div class="form-group demo-radio-button">
                                        <input name="auto_active_user" type="radio" id="auto_active_user_yes" class="radio-col-red" <?=(!empty($result) && $result->auto_active_user == 1)?"checked=''":""?> value="1">
                                        <label for="auto_active_user_yes"><?=l('Yes')?></label>

                                        <input name="auto_active_user" type="radio" id="auto_active_user_no" class="radio-col-red" <?=(!empty($result) && $result->auto_active_user == 0)?"checked=''":""?> value="0">
                                        <label for="auto_active_user_no"><?=l('No')?></label>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                                    <b><?=l('Default delay every post on post now')?></b>
                                    <div class="form-group">
                                        <select name="default_deplay_post_now" class="form-control">
                                            <?php for ($i = 5; $i <= 900; $i++) {
                                            if($i%5 == 0){
                                            ?>
                                                <option value="<?=$i?>" <?=$i==$result->default_deplay_post_now?"selected":""?>><?=$i." ".l('seconds')?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <b><?=l('Minimum delay every post on post now')?></b>
                                    <div class="form-group">
                                        <select name="minimum_deplay_post_now" class="form-control">
                                            <?php for ($i = 5; $i <= 900; $i++) {
                                            if($i%5 == 0){
                                            ?>
                                                <option value="<?=$i?>" <?=$i==$result->minimum_deplay_post_now?"selected":""?>><?=$i." ".l('seconds')?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <b><?=l('Default delay every post on schedule')?></b>
                                    <div class="form-group">
                                        <select name="default_deplay" class="form-control">
                                            <?php for ($i = 1; $i <= 720; $i++) {?>
                                                <option value="<?=$i?>" <?=$i==$result->default_deplay?"selected":""?> ><?=$i." ".l('minutes')?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <b><?=l('Minimum delay every post on schedule')?></b>
                                    <div class="form-group">
                                        <select name="minimum_deplay" class="form-control">
                                            <?php for ($i = 1; $i <= 720; $i++) {?>
                                                <option value="<?=$i?>" <?=$i==$result->minimum_deplay?"selected":""?> ><?=$i." ".l('minutes')?></option>
                                            <?php } ?>  
                                        </select>
                                    </div>
                                    <b><?=l('Maximum size of file uploads')?></b>
                                    <div class="form-group">
                                        <select name="upload_max_size" class="form-control">
                                            <?php for ($i=1; $i < 100; $i++) {?>
                                                <option value="<?=$i?>" <?=$i==$result->upload_max_size?"selected":""?> ><?=$i." ".l('MB')?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title">
                                    <b><?=l('Facebook ID')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="facebook_id" value="<?=!empty($result)?$result->facebook_id:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Facebook Secret')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="facebook_secret" value="<?=!empty($result)?$result->facebook_secret:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Googe Client ID')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="google_id" value="<?=!empty($result)?$result->google_id:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Google Client Secret')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="google_secret" value="<?=!empty($result)?$result->google_secret:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Twitter Consumer Secret')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="twitter_id" value="<?=!empty($result)?$result->twitter_id:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Twitter Consumer Secret')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="twitter_secret" value="<?=!empty($result)?$result->twitter_secret:""?>">
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title2">
                                    <b><?=l('Facebook')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="facebook_page" value="<?=!empty($result)?$result->facebook_page:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Twitter')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="twitter_page" value="<?=!empty($result)?$result->twitter_page:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Pinterest')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="pinterest_page" value="<?=!empty($result)?$result->pinterest_page:""?>">
                                        </div>
                                    </div>

                                    <b><?=l('Instagram')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="instagram_page" value="<?=!empty($result)?$result->instagram_page:""?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-red waves-effect"><?=l('Submit')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <i class="fa fa-key" aria-hidden="true"></i> <?=l('LICENSE')?> 
                    </h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Nav tabs -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                                    <?php if(get('error')){?>
                                    <div class="alert alert-danger">
                                        <?=get('error')?>
                                    </div>
                                    <?php }?>
                                    <b><?=l('Purchase code')?></b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="purchase_code" value="<?=!empty($result)?$result->purchase_code:""?>">
                                        </div>
                                    </div>
                                    <?php if(get('error')){?>
                                    <p>Click <a href="http://guuugle.com/products/grampostpro.php" target="_blank">here</a> to buy this product</p>
                                    <br/>
                                    <?php }?>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-red waves-effect"><?=l('Submit')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>