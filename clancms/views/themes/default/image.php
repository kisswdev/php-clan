<?php $this->load->view(THEME . 'header'); ?>

<?php $this->load->view(THEME . 'sidebar'); ?>
<div id="main">
	<div class="box">
		<div class="header">
			<h4>
				<?php echo $image->title . ' from ' . $image->uploader;?>
				<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $image->uploader): ?>
					<?php echo $actions = anchor('gallery/del_media/' . $image->gallery_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete', 'class' => 'delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
				<?php else: ?>
					<?php echo $actions = ""; ?>
				<?php endif; ?>
			</h4>
		</div>
		<div class="content">
			<div class="inside">
				<div class="gallery">
					<div class="media">
						<?php echo img(array('src' => IMAGES . 'gallery/thumbs/' . $image->image, 'alt' => $image->gallery_slug)); ?>
					</div>
					
					<?php if($this->session->flashdata('message')): ?>
					<div class="alert">
						<?php echo $this->session->flashdata('message'); ?>
					</div>
					<?php endif; ?>
					
					<div class="properties">
						<div class="title"><?php echo $image->title; ?></div>
						<ul class="labels">
							<li>[uploader]&nbsp;</li>
							<li>[uploaded]&nbsp;</li>
							<li>[original size]&nbsp;</li>
							<li>[aspect ratio]&nbsp;</li>
							<li>[file size]&nbsp;</li>
							<li>[views]&nbsp;</li>
							<li>[favors]&nbsp;</li>
							<li>[comments]&nbsp;</li>
							<li>[downloads]&nbsp;</li>
						</ul>
						<ul class="info">
							<li><?php echo $image->uploader; ?></li>
							<li><?php echo mdate("%M %j%S, %Y", $image->date); ?></li>
							<li><?php echo $image->width . ' x ' . $image->height; ?></li>
							<li><?php echo $image->ratio; ?></li>
							<li><?php echo $image->size; ?> kb</li>
							<li><?php echo $image->views; ?></li>
							<li><?php echo $image->favors; ?></li>
							<li><?php echo $image->comments; ?></li>
							<li><?php echo $image->downloads; ?></li>
						</ul>
						<div class="clear"></div>
						<?php if($this->user->logged_in()): ?>
						<ul class="share">
							<?php echo anchor('gallery/download/' . $image->gallery_slug, '<li class="download"></li>', array('title' => 'Download original size'));?>
							<li class="favor"></li>					
							<li class="stumble"></li>		
							<?php echo anchor($image->fblink,'<li class="facebook"></li>',array('title'=>'Share on facebook', 'target'=>'_blank'));?>
						</ul>
						<?php endif; ?>
					</div>
					
					<div class="gallery_description">
						<div class="uploader">
							<?php if($image->avatar): ?>
								<?php echo anchor('account/profile/' . $image->uploader, img(array('src' => IMAGES . 'avatars/' . $image->avatar, 'title' => $image->uploader, 'alt' => $image->uploader, 'width' => '75', 'height' => '75'))); ?>
							<?php else: ?>
								<?php echo anchor('account/profile/' . $image->uploader, img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $image->avatar, 'alt' => $image->avatar, 'width' => '75', 'height' => '75'))); ?>
							<?php endif; ?>
							<span><?php echo $image->uploader;?></span>
							<span class=<?php if($image->group == 'Administrators'): echo 'admin'; else: echo 'user'; endif; ?>><?php if($image->group): echo $image->group; endif;?></span>
						</div>
						<div class="uploader_desc">
							<?php if($image->desc): ?>
								<?php if($this->user->is_administrator() OR $this->session->userdata('username') == $image->uploader): ?>
									<?php echo img(array('src' => THEME_URL . 'images/edit.png', 'title' => 'Edit', 'alt' => 'Edit Description', 'class' => 'right edit')); ?>
									<div id="edit" style="display: none;">
									<?php echo form_open('gallery/image/' . $image->gallery_slug); ?>
									<?php $data = array(
											'name'		=> 'desc',
											'rows'		=> '4',
											'cols'			=> '40',
											'value'		=> $image->desc
											);
									echo form_textarea($data); ?>
									<?php $data = array(
												'name'		=> 'add_desc',
												'class'		=> 'submit',
												'value'		=> 'Describe'
											);
										echo form_submit($data); ?>
									<button id="cancel" class="submit ui-button ui-widget ui-state-default ui-corner-all">Cancel</button>
									<?php echo form_close(); ?>
									</div>
								<?php endif; ?> 
							
								<p><?php echo $image->desc; ?></p>
							<?php else: ?>
								<?php if($this->session->userdata('username') == $image->uploader): ?>
									<?php echo form_open('gallery/image/' . $image->gallery_slug); ?>
									<?php
										$data = array(
											'name'		=> 'desc',
											'rows'		=> '4',
											'cols'			=> '40'
										);
									
									echo form_textarea($data); ?>
									<?php 
											$data = array(
												'name'		=> 'add_desc',
												'class'		=> 'submit',
												'value'		=> 'Describe'
											);
										
										echo form_submit($data); ?>
										<div class="clear"></div>
									<?php echo form_close(); ?>
								<?php else: ?>
									No description given by uploader
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<?php if($this->user->logged_in() && $this->session->userdata('username') != $image->uploader): ?>
						<div class="right"> More from this uploader: <?php echo anchor('gallery/user/' . $image->uploader, 'here'); ?></div>
					<?php endif;?>
					
					<div class="gallery_comments">
						<?php if($this->user->logged_in() && $user->has_voice == 1): ?>
								<?php echo form_open('gallery/image/' . $image->gallery_slug); ?>
								<?php
									$data = array(
										'name'		=> 'comment',
										'rows'		=> '2',
										'cols'			=> '46'
									);
								
								echo form_textarea($data); ?>
								<?php 
										$data = array(
											'name'		=> 'add_comment',
											'class'		=> 'submit',
											'value'		=> 'Comment'
										);
									
									echo form_submit($data); ?>
							<div class="clear"></div>
						<?php endif; ?>
						<?php echo br(); ?>
						
						<?php if($comments): ?>
							<?php foreach($comments as $comment): ?>
								<?php if($comment->author == $image->uploader): $style = '<ul class = "author">'; else: $style = '<ul>';  endif; ?>
									
							<?php echo $style; ?>
								<li class="poster">
									<?php if($comment->avatar): ?>
										<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => IMAGES . 'avatars/' . $comment->avatar, 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
									<?php else: ?>
										<?php echo anchor('account/profile/' . $this->users->user_slug($comment->author), img(array('src' => THEME_URL . 'images/avatar_none.png', 'title' => $comment->author, 'alt' => $comment->author, 'width' => '57', 'height' => '57'))); ?>
									<?php endif; ?>
								</li>
								<?php if($comment->author == $image->uploader): echo '<li class = "right"><span class="admin">***UPLOADER***</span></li>'; endif; ?>
								<li class="post_head">
									<?php if($this->user->is_administrator() OR $this->session->userdata('user_id') == $comment->user_id): ?>
										<?php $actions = anchor('gallery/delete_comment/' . $comment->comment_id, img(array('src' => THEME_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?>
									<?php else: ?>
										<?php $actions = ""; ?>
									<?php endif; ?>
									<?php echo anchor('account/profile/' . $comment->author, $comment->author) . ' Posted ' . mdate("%M %d, %Y at %h:%i %a ", $comment->date) . $actions; ?>
								</li>
								<li class="posted"><?php echo $comment->comment_title; ?></li>
							</ul>
							<?php endforeach; ?>
						<?php else: ?>
								No one has yet commented on this image. <?php if(!$this->user->logged_in()): echo 'Please ' . anchor('account/login', 'login') . ' to post comments.'; endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="space"></div>
</div>
<script>
$(document).ready(function() {
	// Get the  current URL
	var pathname = window.location;
	 
	// Create the twitter URL
	var tweeturl = 'https://www.twitter.com/share?status='+pathname+'&via=codezyne_me&text=Check this out!';
	
	// Add tweeter
	$('.share').append('<a href="'+ tweeturl+'"><li class="twitter" title="Tweet this image"></li></a>')
	
	})
</script>
<script>
	$(".edit").click(function () {
	  $("div#edit").show("fast", function () {
	    /* use callee so don't have to name the function */
	    $(this).next("div.edit").show("fast", arguments.callee);
	  });
	});
	$("#cancel").click(function () {
	  $("div.edit").hide(2000);
	});

</script>

<?php $this->load->view(THEME . 'footer'); ?>