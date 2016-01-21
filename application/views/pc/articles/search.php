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
				<div class="table">
					<?php foreach($articles_brief as $article) { ?>
						<div class="row">
							<div class="article_title">
								<a href="<?=URL_HOME?>/articles/read/<?=$article->article_id.'/'.$article->friendly_url?>">
									<?=$article->title?>
								</a>
							</div>
							
							<input type="hidden" name="weight" value="<?=$article->sum_weight?>">
							
							<div class="article_meta">
								#<?=$article->article_id?> • 
								<a href="<?=URL_HOME?>/articles/categories/<?=$article->category_id.'/'.$article->category_friendly_url?>"><?=$article->category_name?></a> • 
								<a href="http://www.stdio.vn/users/index/<?=$article->author_id.'/'.$article->author_friendly_url?>"><?=$article->last_name . ' ' . $article->first_name?></a> 
								
							</div>
							
							<div class="article_brief">
								<?=$article->description?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php } else { ?>
				<div>Không tìm được bài viết liên quan</div>
			<?php } ?>
			
			<div class="wrapper_content_column_2_element">
				<div class="paging"><?=$PAGINATION_STR?></div>
			</div>
		</div>
		
		<div class="wrapper_content_column_3">

		</div>
	</div>
</section>