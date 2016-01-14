<section class="wrapper_section wrapper_content">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">

		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
				<?php $this->load->view('shared/include/control_search_articles')?>
			</div>
			
			<div class="title_base title_color_darkorange"><span>TÌM KIẾM <?=htmlspecialchars($keywords)?></span></div>

			<?php if (count($articles_brief) > 0) { ?>
			<div class="wrapper_content_column_2_element">
				 <?php foreach($articles_brief as $article) { ?>
				 	<div><?=$article->article_id?></div>
					<div><?=$article->title?></div>
					<div><?=$article->description?></div>
					</br>
				<?php } ?>
			</div>
			<?php } else { ?>
				<div>Không tìm được bài viết liên quan</div>
			<?php } ?>
		</div>
		
		<div class="wrapper_content_column_3">

		</div>
	</div>
</section>