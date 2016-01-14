<section class="wrapper_section wrapper_content">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">
			
		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
				<?php $this->load->view('shared/include/control_search_articles')?>
			</div>
			
			<div class="wrapper_content_column_2_element">
				<div class="articles_concerned_categories">
					<a href="/articles/index/0/1" <?=$CURRENT_CATEGORY==0?'class="active"':''?>>Tất cả</a>
					<? foreach ($CONCERNED_CATEGORY as $item) { ?>
						<a href="/articles/index/<?=$item->a_id.'/'.$item->a_friendly_url?>" <?=$item->a_id==$CURRENT_CATEGORY?'class="active"':''?>><?=$item->a_category_name?></a>
					<? } ?>
					
					<a href="/articles/categories">~</a>
				</div>
			</div>

			<!--<? if ($FEARTURE_ARTICLES != NULL) { ?>
			<div class="wrapper_content_column_2_element">
				<div class="articles_featured_articles background_color_light_grey">	
					<h3><i class="fa fa-paperclip fa-fw"></i> BÀI VIẾT TIÊU BIỂU</h3>
					<div class="list_articles">
						<? foreach ($FEARTURE_ARTICLES as $item) { ?>
							<div class="ele_article">
								<div class="ele_article_left" title="<?=$item->a_type_name?>">
									<?=$item->a_type_icon?>
								</div>
								<div class="ele_article_right">
									<div class="article_title">
										<a href="/articles/read/<?=$item->a_id?>/<?=$item->a_friendly_url?>">
											<?=$item->a_title?>
										</a>
									</div>
	
									<div class="article_meta">
										<a href="/articles/category/<?=$item->a_category_id.'/'.$item->ac_friendly_url?>"><?=$item->a_category_name?></a>
										<span>
											<?=GetNameByOrder($item->a_first_name, $item->a_last_name, $item->a_name_order)?>										 
											<i class="fa fa-clock-o"></i> <?=date('d/m/Y', strtotime($item->a_date_created))?> <i class="fa fa-eye"></i> <?=$item->a_page_view?>
										</span>
									</div>
	
									<div class="article_brief">
										<?=$item->a_brief?>
									</div>
									
								</div>
							</div>
						<? } ?>
					</div>
				</div>
			</div>
			<? } ?>			
			
			<div class="wrapper_content_column_2_element">
				<div class="articles_normal_articles">
					<div class="title_base title_color_darkorange"><span><i class="fa fa-bolt fa-fw"></i> BÀI VIẾT MỚI NHẤT</span></div>
					<div class="list_articles">
						<? foreach ($NORMAL_ARTICLES as $item) {	?>
							<div class="ele_article">
								<div class="ele_article_left" title="<?=$item->a_type_name?>">
									<?=$item->a_type_icon?>
								</div>
								<div class="ele_article_right">
									<div class="article_title">
										<a href="/articles/read/<?=$item->a_id.'/'.$item->a_friendly_url?>">
											<?=$item->a_title?>
										</a>
									</div>
									
									<div class="article_meta">
										<a href="/articles/category/<?=$item->a_category_id.'/'.$item->ac_friendly_url?>"><?=$item->a_category_name?></a>
										<span>
											<?=GetNameByOrder($item->a_first_name, $item->a_last_name, $item->a_name_order)?>
											 <i class="fa fa-clock-o"></i> <?=date('d/m/Y', strtotime($item->a_date_created))?> <i class="fa fa-eye"></i> <?=$item->a_page_view?>
										</span>
									</div>
									
									<div class="article_brief">
										<?=$item->a_brief?>
									</div>
									
								</div>
							</div>
						<? } ?>
					</div>
				</div>
			</div>
			
			<div class="wrapper_content_column_2_element">
				<div class="paging"><?=$PAGINATION_STR?></div>
			</div>
		</div>-->

		<div class="wrapper_content_column_3">
			
		</div>
	</div>
</section>