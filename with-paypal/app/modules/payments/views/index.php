<div class="pricing-table">
	<div class="title"><?=l('PICK THE BEST PLAN FOR YOU!')?></div>
	<?php if(!empty($package)){?>

	<?php foreach ($package as $row) {
		$price = explode(".", $row->price);
		$permission = json_decode($row->permission);
	?>
	<div class="whole">
		<div class="type">
			<p><?=$row->name?></p>
			</div>
		<div class="plan">
			<div class="header">
				<span><?=$payment->symbol?></span><?=$price[0]?><sup><?=(isset($price[1])?$price[1]:"00")?></sup>
				<p class="month">/<?=$row->day?> <?=l('days')?></p>
			</div>
			<div class="content">
				<ul>
					<li class="bg-light-green"><?=$permission->maximum_account?> <?=l('Instagram Accounts')?></li>
					<li><?=l('Auto post')?> <?=permission_list($row->permission, 'post')?></li>
				</ul>
			</div>
			<div class="price">
				<?php if(session("uid")){?>
	      			<a href="<?=cn("do_payment?package=".$row->id)?>" class="btn btn-block bg-light-green btn-lg waves-effect"><?=l('UPGRADE NOW')?></a>
				<?php }else{?>
					<a href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" class="btn btn-block bg-light-green btn-lg waves-effect"><?=l('UPGRADE NOW')?></a>
	      		<?php }?>
			</div>
		</div>
	</div>
	<?php }?>

	<?php }?>
</div>
<?=modules::run("blocks/footer")?>