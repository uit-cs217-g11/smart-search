<? $ARTICLE_ID = 0; ?>

<section class="wrapper_section wrapper_content" itemscope itemtype="http://schema.org/Article">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">
			
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
						<div class="article_meta_info">							
							#<?=$article->article_id?> • 
							<a href="<?=URL_HOME?>/articles/categories/<?=$article->category_id.'/'.$article->category_friendly_url?>"><?=$article->category_name?></a> • 
							<a href="http://www.stdio.vn/users/index/<?=$article->author_id.'/'.$article->author_friendly_url?>"><?=$article->last_name . ' ' . $article->first_name?></a> 
							<i class="fa fa-clock-o"></i>
						</div>
					</div>
					
					<h1 itemprop="name"><?=$article->title?></h1>
					
					<article class="article_content" itemprop="articleBody">
						<?=$article->content?>
					</article>

					<div class="article_tag">
						<div class="ele_tag"><i class="fa fa-tags fa-fw"></i><b>TAGS</b></div>
						<?php
							$tags_list = explode('|', $article->tags);
							foreach($tags_list as $tag)
							{
								echo '<div class="ele_tag">'.$tag.'</div>';
							}
						?>
					</div>
				</div>
			</div>
			<?php } ?>		
			
			
		</div>
	</div>
</section>