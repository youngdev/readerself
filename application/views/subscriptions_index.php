	<nav>
		<ul class="actions">
			<li class="hide-phone hide-tablet"><a href="javascript:void(function(){window.open('<?php echo base_url(); ?>?u='+encodeURIComponent(window.location.href),'_blank');}());"><i class="icon icon-bookmark"></i><?php echo $this->config->item('title'); ?> (bookmarklet)</a></li>
			<li class="hide-phone hide-tablet" id="registerContentHandler"><a href="#"><i class="icon icon-save"></i><?php echo $this->lang->line('registerContentHandler'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>subscriptions/create"><i class="icon icon-plus"></i><?php echo $this->lang->line('add'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>subscriptions/import"><i class="icon icon-download-alt"></i><?php echo $this->lang->line('import'); ?></a></li>
			<li><a href="<?php echo base_url(); ?>subscriptions/export"><i class="icon icon-upload-alt"></i><?php echo $this->lang->line('export'); ?></a></li>
		</ul>
	</nav>
</header>
<aside>
	<ul>
		<li>
			<?php echo form_open(current_url()); ?>
				<p>
				<?php echo form_label($this->lang->line('title'), 'subscriptions_fed_title'); ?>
				<?php echo form_input($this->router->class.'_subscriptions_fed_title', set_value($this->router->class.'_subscriptions_fed_title', $this->session->userdata($this->router->class.'_subscriptions_fed_title')), 'id="subscriptions_fed_title" class="inputtext"'); ?>
				</p>
				<?php if($this->config->item('folders')) { ?>
					<p>
					<?php echo form_label($this->lang->line('folder'), 'subscriptions_flr_id'); ?>
					<?php echo form_dropdown($this->router->class.'_subscriptions_flr_id', $folders, set_value($this->router->class.'_subscriptions_flr_id', $this->session->userdata($this->router->class.'_subscriptions_flr_id')), 'id="subscriptions_flr_id" class="select numeric"'); ?>
					</p>
				<?php } ?>
				<p>
				<?php echo form_label($this->lang->line('priority'), 'subscriptions_sub_priority'); ?>
				<?php echo form_dropdown($this->router->class.'_subscriptions_sub_priority', array('' => '--', 0 => $this->lang->line('no'), 1 => $this->lang->line('yes')), set_value($this->router->class.'_subscriptions_sub_priority', $this->session->userdata($this->router->class.'_subscriptions_sub_priority')), 'id="subscriptions_sub_priority" class="select numeric"'); ?>
				</p>
				<?php if($errors > 0) { ?>
					<p>
					<?php echo form_label($this->lang->line('errors').' ('.$errors.')', 'subscriptions_fed_lasterror'); ?>
					<?php echo form_dropdown($this->router->class.'_subscriptions_fed_lasterror', array('' => '--', 0 => $this->lang->line('no'), 1 => $this->lang->line('yes')), set_value($this->router->class.'_subscriptions_fed_lasterror', $this->session->userdata($this->router->class.'_subscriptions_fed_lasterror')), 'id="subscriptions_fed_lasterror" class="select numeric"'); ?>
					</p>
				<?php } ?>
				<p>
				<button type="submit"><?php echo $this->lang->line('send'); ?></button>
				</p>
			<?php echo form_close(); ?>
		</li>
		<?php if($last_added) { ?>
		<li><h2><i class="icon icon-bookmark-empty"></i><?php echo $this->lang->line('last_added'); ?></h2></li>
			<?php foreach($last_added as $added) { ?>
			<li<?php if($added->direction) { ?> dir="<?php echo $added->direction; ?>"<?php } ?>><a style="background-image:url(https://www.google.com/s2/favicons?domain=<?php echo $added->fed_host; ?>&amp;alt=feed);" class="favicon" href="<?php echo base_url(); ?>subscriptions/read/<?php echo $added->sub_id; ?>"><?php echo $added->fed_title; ?></a></li>
			<?php } ?>
		<?php } ?>
	</ul>
</aside>
<main>
	<section>
		<section>
		<article class="title">
			<h2><i class="icon icon-bookmark"></i><?php echo $this->lang->line('subscriptions'); ?> (<?php echo $position; ?>)</h2>
		</article>
	<?php if($subscriptions) { ?>
		<?php foreach($subscriptions as $sub) { ?>
		<article<?php if($sub->direction) { ?> dir="<?php echo $sub->direction; ?>"<?php } ?>>
			<ul class="actions">
				<li><a class="priority" href="<?php echo base_url(); ?>subscriptions/priority/<?php echo $sub->sub_id; ?>"><span class="priority"<?php if($sub->sub_priority == 0) { ?> style="display:none;"<?php } ?>><i class="icon icon-flag"></i><?php echo $this->lang->line('not_priority'); ?></span><span class="not_priority"<?php if($sub->sub_priority == 1) { ?> style="display:none;"<?php } ?>><i class="icon icon-flag-alt"></i><?php echo $this->lang->line('priority'); ?></span></a></li>
				<li><a href="<?php echo base_url(); ?>subscriptions/update/<?php echo $sub->sub_id; ?>"><i class="icon icon-wrench"></i><?php echo $this->lang->line('update'); ?></a></li>
				<li><a href="<?php echo base_url(); ?>subscriptions/delete/<?php echo $sub->sub_id; ?>"><i class="icon icon-bookmark"></i><?php echo $this->lang->line('unsubscribe'); ?></a></li>
			</ul>
			<h2><a style="background-image:url(https://www.google.com/s2/favicons?domain=<?php echo $sub->fed_host; ?>&amp;alt=feed);" class="favicon" href="<?php echo base_url(); ?>subscriptions/read/<?php echo $sub->sub_id; ?>"><?php echo $sub->fed_title; ?><?php if($sub->sub_title) { ?> / <em><?php echo $sub->sub_title; ?></em><?php } ?></a></h2>
			<ul class="item-details">
				<?php if($sub->fed_lastcrawl) { ?><li><i class="icon icon-truck"></i><?php echo $sub->fed_lastcrawl; ?></li><?php } ?>
				<li><i class="icon icon-group"></i><?php echo $sub->subscribers; ?> <?php if($sub->subscribers > 1) { ?><?php echo mb_strtolower($this->lang->line('subscribers')); ?><?php } else { ?><?php echo mb_strtolower($this->lang->line('subscriber')); ?><?php } ?></li>
				<li class="hide-phone"><a href="<?php echo $sub->fed_link; ?>" target="_blank"><i class="icon icon-rss"></i><?php echo $sub->fed_link; ?></a></li>
				<?php if($this->config->item('folders')) { ?>
					<li><?php if($sub->flr_title) { ?><a href="<?php echo base_url(); ?>folders/read/<?php echo $sub->flr_id; ?>"><i class="icon icon-folder-close"></i><?php echo $sub->flr_title; ?></a><?php } else { ?><i class="icon icon-folder-close"></i><em><?php echo $this->lang->line('no_folder'); ?></em><?php } ?></li>
				<?php } ?>
				<?php if($sub->fed_url) { ?><li class="block"><a href="<?php echo $sub->fed_url; ?>" target="_blank"><i class="icon icon-external-link"></i><?php echo $sub->fed_url; ?></a></li><?php } ?>
				<?php if($this->config->item('tags') && $sub->categories) { ?>
				<li class="block hide-phone"><i class="icon icon-tags"></i><?php echo implode(', ', $sub->categories); ?></li>
				<?php } ?>
				<?php if($sub->fed_lasterror) { ?><li class="block"><i class="icon icon-bell"></i><?php echo $sub->fed_lasterror; ?></li><?php } ?>
			</ul>
			<div class="item-content">
				<?php echo $sub->fed_description; ?>
			</div>
		</article>
		<?php } ?>
		<div class="paging">
			<?php echo $pagination; ?>
		</div>
	<?php } ?>
		</section>
	</section>
</main>
