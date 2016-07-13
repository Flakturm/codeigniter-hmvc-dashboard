<!-- Header Carousel -->
<header class="business-header">
	<img src="<?php echo base_url() . 'uploads/' . $event['event_pic']; ?>" class="img-responsive" alt="Banner">
</header>
<!-- Page Content -->
<div class="container">

	<!-- Content Start -->
	<div class="row mt35">
		<div class="col-lg-12">
			<h2 class="page-header text-green no-padding-b">
				<?php echo $event['room_title']; ?>
			</h2>
		</div>
	</div>
	<?php if ( date('Y-m-d H:i:s') >= $event['enroll_open_time'] 
		AND date('Y-m-d H:i:s') <= $event['enroll_close_time'] 
		AND ! $remaining_slots ): 
		?>
		<div class="alert alert-dismissable alert-warning mb5">
			<span class="h4">名額已滿</span>
		</div>
	<?php elseif ( date('Y-m-d H:i:s') > $event['enroll_close_time'] ): ?>
		<div class="alert alert-warning mb5">
			<span class="h4">報名截止</span>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-md-6">
			<div class="padding-text h3">時間：<span class="h3"><?php echo date('Y/m/d H:i', strtotime($event['room_open_time'])); ?> - <?php echo date('H:i', strtotime($event['room_close_time'])); ?></span></div>
			<div class="padding-text h3">報名費：<span class="h2">NT$<?php echo number_format($event['fees'], 0, '.', ','); ?> </span><span class="h3">元</span></div>
		</div>
		<div class="col-md-6">
			<div class="padding-text h3">店名：<span class="h3" id="shop-name"><?php echo $event['restaurant_name']; ?></span></div>
			<div class="padding-text h3">地址：<span id="shop-addr"><a href="https://www.google.com.tw/maps/place/<?php echo $event['restaurant_address']; ?>" target="_blank"><?php echo $event['restaurant_address']; ?></a></span></div>
		</div>
	</div>
	<?php 
	echo form_open('event/step1', '', $event); 
	?>
	<?php if ( date('Y-m-d H:i:s') >= $event['enroll_open_time'] AND date('Y-m-d H:i:s') <= $event['enroll_close_time'] 
	AND ( $remaining_slots OR $remaining_waiting_slots ) ): ?>
	<div class="col-md-3 col-sm-12 col-xs-12 padding-text h3">
		<div class="form-group" style="min-width:350px;">
			<label for="sel1" class="col-md-4 col-sm-3 col-xs-4 text-grey pl0 pr0">報名人數</label>
			<select name="extra_people" class="col-md-1 col-sm-1 col-xs-1 form-control" id="sel1" style="width:25%;">
				<?php $slots = ($remaining_slots > 0)? $remaining_slots : $remaining_waiting_slots; ?>
				<?php $pack_size = ($slots < $event['pack_size']) ? $slots : $event['pack_size'] ?>
				<?php for($i = 1; $i <= $pack_size; $i++): ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</div>
	</div>
<?php endif; ?>
<div class="col-md-7 col-sm-12 col-xs-12 padding-text">
	<?php if ( date('Y-m-d H:i:s') <= $event['enroll_open_time'] AND date('Y-m-d H:i:s') <= $event['enroll_close_time'] ): ?>
		<span class="btn btn-gb">尚未開放</span>
	<?php elseif ( date('Y-m-d H:i:s') >= $event['enroll_open_time'] AND date('Y-m-d H:i:s') <= $event['enroll_close_time'] ): ?>
		<?php if ( $remaining_slots ): ?>
			<button type="submit" class="btn btn-rb">立即報名</button>
		<?php elseif ( $remaining_waiting_slots ): ?>
			<button type="submit" class="btn btn-rb">我要候補</button>
			<?php
			$data = array(
				'order_status'  => '候補'
				);
			echo form_hidden($data);
			?>
		<?php else: ?>
			<span class="btn btn-gb">候補已滿</span>
		<?php endif; ?>
	<?php else: ?>
		<?php if ($event['expired_url']): ?>
			<a href="<?php echo prep_url($event['expired_url']); ?>" class="btn btn-lb" target="_blank">幕後花絮</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ($event['menu_url']): ?>
		<a href="<?php echo prep_url($event['menu_url']); ?>" class="btn btn-db" target="_blank">看菜單</a>
	<?php endif; ?>
	<?php if ( date('Y-m-d H:i:s') >= $event['enroll_open_time'] 
		AND date('Y-m-d H:i:s') <= $event['enroll_close_time'] 
		AND ! $remaining_slots
		AND $remaining_waiting_slots
		): ?>
		<div class="mt15">
			<a href="" class="not-link" data-toggle="popover" data-placement="right" data-trigger="focus" data-content="候補資料填寫完成後，若有名額釋出，將由專人和您聯繫；若無名額釋出，將不會主動和您聯繫，謝謝！"><i class="ico-question-sign mr5"></i>候補說明</a>
		</div>
	<?php endif; ?>
</div>
<?php echo form_close(); ?>
<div class="row">
	<div class="col-lg-12">
		<ul class="social">
			<li><a href="http://www.facebook.com/share.php?u=<?php echo current_url(); ?>" title="分享文章至 FB" target="_blank"><img src="<?php echo base_url(); ?>theme/img/others/fb.png" alt="fb"></a></li>
			<li><a href="https://plus.google.com/share?url=<?php echo current_url(); ?>" title="分享文章至 Google+" target="_blank"><img src="<?php echo base_url(); ?>theme/img/others/google.png" alt="Google"></a></li>
			<li><a href="http://twitter.com/home/?status=<?php echo $event['event_title']; ?> <?php echo current_url(); ?>" title="分享文章至 Twitter" target="_blank"><img src="<?php echo base_url(); ?>theme/img/others/twitter.png" alt="twitter"></a></li>
			<li><a href="http://line.naver.jp/R/msg/text/?<?php echo $event['event_title']; ?>%0D%0A<?php echo current_url(); ?>" title="分享文章至 Line" target="_blank"><img src="<?php echo base_url(); ?>theme/img/others/line.png" alt="line"></a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<h2 class="text-green no-padding-b no-margin-t">
			<?php echo $event['event_title']; ?>
		</h2>
		<div class="h3">
			<?php echo $event['event_description']; ?>
		</div>
	</div>
	<div class="col-md-6">
		<?php if ( $event['youtube_code'] ): ?>
			<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo $event['youtube_code']; ?>?showinfo=0" frameborder="0" allowfullscreen></iframe>
		<?php else: ?>
			<img class="img-responsive img-portfolio" src="<?php echo base_url() . 'uploads/' . $event['menu_pic']; ?>" alt="menu" title="menu">
		<?php endif; ?>
	</div>
</div>
<!-- /.IMG END -->

<!-- Restaurant Section -->
<div class="row padding-top-50">
	<div class="col-md-6">
		<img class="img-responsive img-portfolio" src="<?php echo base_url() . 'uploads/' . $event['restaurant_pic']; ?>" alt="Restaurant" title="Restaurant">
	</div>
	<div class="col-md-6">
		<h2 class="text-green no-padding-b no-margin-t">
			<?php echo $event['restaurant_chef']; ?>
		</h2>
		<div class="h3">
			<?php echo $event['restaurant_description']; ?>
		</div>
	</div>
</div>
<!-- /.row -->
<?php $this->load->view('front/bank_note'); ?>
<!-- /.container -->
</div>