<?php $this->load->view(ADMINCP . 'header'); ?>

<?php $this->load->view(ADMINCP . 'sidebar'); ?>

 <script type="text/javascript">
	function deleteConfirm()
	{
    	var answer = confirm("Are you sure you want to delete this match? Once deleted, there will be no way to recover the match and player stats!")
    	if (answer)
		{
        	document.messages.submit();
    	}
    
    	return false;  
	} 
</script> 

<div id="main">

	<div class="box">
		<div class="tabs">
		<ul>
			<li class="selected"><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches', 'Matches'); ?></span><span class="right"></span></li>
			<li><span class="left"></span><span class="middle"><?php echo anchor(ADMINCP . 'matches/add', 'Add Match'); ?></span><span class="right"></span></li>
		</ul>
		</div>
		
		<div class="header">
			<?php echo heading('Matches', 4); ?>
		</div>
		
		<div class="content">
			<div class="inside">
			
			<?php if($this->session->flashdata('message')): ?>
				<div class="alert">
					<?php echo $this->session->flashdata('message'); ?>
				</div>
				<?php echo br(); ?>
			<?php endif; ?>
				
		<table>
			<thead>
				<tr>
					<th width="30%">Opponent</th>
					<th width="15%">Score</th>
					<th width="30%">Squad</th>
					<th width="15%">Date</th>
					<th width="10%">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php if($matches): ?>
				<?php foreach($matches as $match): ?>
				<tr>
					<td><?php if($match->match_opponent_link): echo anchor($match->match_opponent_link, $match->match_opponent); else: echo $match->match_opponent; endif; ?></td>
					<td <?php if($match->match_score > $match->match_opponent_score): echo 'class="green"'; elseif($match->match_score < $match->match_opponent_score): echo 'class="red"'; else: echo 'class="yellow"'; endif;?>><?php echo $match->match_score . ' - ' . $match->match_opponent_score; ?></td>
					<td><?php echo anchor(ADMINCP . 'squads/edit/' . $match->squad_id, $match->squad); ?></td>
					<td><?php echo mdate("%M %d, %Y", $match->date); ?></td>
					<td><?php echo anchor(ADMINCP . 'matches/edit/' . $match->match_id, img(array('src' => ADMINCP_URL . 'images/edit.png', 'alt' => 'Edit')), array('title' => 'Edit')); ?> <?php echo anchor(ADMINCP . 'matches/delete/' . $match->match_id, img(array('src' => ADMINCP_URL . 'images/delete.png', 'alt' => 'Delete')), array('title' => 'Delete', 'onclick' => "return deleteConfirm();")); ?></td>
				</tr>
				<?php endforeach; ?>
				<?php else: ?>
				<tr>
					<td colspan="5">There are currently no matches. Click <?php echo anchor(ADMINCP . 'matches/add', 'Add Match'); ?> to add one.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="space"></div>
	
	<div class="box">
		<div class="pages">
			<?php echo heading($pages, 4); ?>
		</div>
	</div>
</div>


<?php $this->load->view(ADMINCP . 'footer'); ?>