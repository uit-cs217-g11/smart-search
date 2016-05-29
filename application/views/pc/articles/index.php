<section class="wrapper_section wrapper_content">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">
			
		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
				<?php $this->load->view('shared/include/control_search_articles')?>
			</div>
			
			<div class="wrapper_content_column_2_element">
				<div class="promote_categories">
					<a href="<?=URL_HOME?>/articles/index/0/1" <?=$current_category==0?'class="active"':''?>>Tất cả</a>
					<?php foreach ($promote_categories as $item) { ?>
						<a href="<?=URL_HOME?>/articles/index/<?=$item->id.'/'.$item->friendly_url?>" <?=$item->id==$current_category?'class="active"':''?>><?=$item->category_name?></a>
					<?php } ?>
					
					<a href="<?=URL_HOME?>/articles/categories">~</a>
				</div>
			</div>
			
			<div class="wrapper_content_column_2_element">
				<div class="articles_normal_articles">
					<div class="title_base title_color_darkorange"><span><i class="fa fa-bolt fa-fw"></i> BÀI VIẾT MỚI NHẤT</span></div>
					
					<div class="table">
						<?php foreach ($brief_articles as $article) { ?>
							<div class="row">
							<div class="article_title">
								<a href="<?=URL_HOME?>/articles/read/<?=$article->article_id.'/'.$article->friendly_url?>">
									<?=$article->title?>
								</a>
							</div>
							
							<div class="article_meta">
								#<?=$article->article_id?> • 
								<a href="<?=URL_HOME?>/articles/categories/<?=$article->category_id.'/'.$article->category_friendly_url?>"><?=$article->category_name?></a> • 
								<a href="http://www.stdio.vn/users/index/<?=$article->author_id.'/'.$article->author_friendly_url?>"><?=$article->author_name?></a> 
								
							</div>
							
							<div class="article_brief">
								<?=$article->description?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<div class="wrapper_content_column_2_element">
				<div class="paging"><?=$PAGINATION_STR?></div>
			</div>
		</div>

		<div class="wrapper_content_column_3">
			
		</div>
	</div>
</section>