<? $ARTICLE_ID = 0; ?>

<section class="wrapper_section wrapper_content" itemscope itemtype="http://schema.org/Article">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">
			<div class="wrapper_content_column_1_element">		
				<div class="article_promo_ele">
					<? if (isset($NewestArticles)) { ?>
						<div class="title_base title_color_lightblue"><span><i class="fa fa-folder fa-fw"></i> BÀI CÙNG LOẠI</span></div>
						<?if(count($NewestArticles) == 1){?>
							<ul><li>Chưa có bài nào khác cùng thể loại này.</li></ul>
						<?}?>
						
						<ul>
						<!--<? foreach ($NewestArticles as $item) { ?>
							<? if ($item->a_id != $ARTICLE_ID) { ?>
							<li><a href="/articles/read/<?=$item->a_id.'/'.$item->a_friendly_url?>">
								<?=$item->a_title?> <i class="fa fa-caret-right"></i>
							</a></li>
							<? } ?>
						<? } ?>-->
						</ul>
					<? } ?>
				</div>			
			</div>
		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
				<?php $this->load->view('shared/include/control_search_articles')?>
			</div>
			
			<?php if(isset($article)) { 
				$ARTICLE_ID = $article->article_id;
			?>

			<div class="wrapper_content_column_2_element">
				<div class="article_box">
					<div class="article_meta">
						<div class="article_meta_left">
							<div class="article_meta_info">							
								#<?=$article->article_id?> •
								<a href="<?=URL_HOME?>/articles/category/<?=$article->category_id.'/'.$article->category_friendly_url?>"><span itemprop="articleSection"><?=$article->category_name?></span></a> • 
								<i class="fa fa-clock-o"></i>
							</div>
							<h1 itemprop="name"><?=$article->title?></h1>
						</div>
					</div>
				
					<article class="article_content" itemprop="articleBody">
						<?=$article->content?>
					</article>

					<div class="article_tag">
						<div class="ele_tag"><i class="fa fa-tags fa-fw"></i> <b>TAGS</b></div>
						<?
							foreach($article->a_tags as $tag)
							{
								echo '<div class="ele_tag">'.$tag.'</div>';
							}
						?>
					</div>
				</div>
			</div>
			<?php } ?>		
			
			
		</div>
	
		<div class="wrapper_content_column_3">
			<div class="wrapper_content_column_element">
				<div class="title_base title_color_darkblue"><span>NỘI DUNG BÀI VIẾT</span></div>
				<div class="anchor_horizontal left" id="id_articles_outline_anchor_id"></div>
				<div class="outline_box" id="id_outline_box_id"></div>
			</div>
		</div>
	</div>
</section>