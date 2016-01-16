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
			
			<? if(isset($Article)) { 
				$ARTICLE_ID = $Article->a_id;
			?>

			<!--<div class="wrapper_content_column_2_element">
				<div class="article_box">
					<div class="article_meta">
						<div class="article_meta_left">
							<div class="article_meta_info">							
								#<?=$Article->a_id?> •
								<a href="/articles/category/<?=$Article->a_category_id.'/'.$Article->ac_friendly_url?>"><span itemprop="articleSection"><?=$Article->a_category_name?></span></a> • 
								<a href="/users/index/<?=$Article->a_author_id?>/<?=$Article->aa_friendly_url?>"><?=GetNameByOrder($Article->a_first_name, $Article->a_last_name, $Article->a_name_order)?></a> •
								<i class="fa fa-clock-o"></i>
								<span itemprop="datePublished" content="<?=DateTimeToString($Article->a_date_created)?>">
									<?=DateTimeToString($Article->a_date_created)?>
								</span> •
								<i class="fa fa-eye"></i> <?=$Article->a_page_view?>
							</div>
							<h1 itemprop="name"><?=$Article->a_title?></h1>
						
							<div class="meta_info_feature">
								<div class="width_100 height_30 left" title="Tạo bản in bài viết">
									<a href="/articles/printing/<?=$Article->a_id.'/'.$Article->a_friendly_url?>" />
										<i class="fa fa-print fa-lg color_orange"></i>
										<span class="color_black"> TẠO BẢN IN</span>						
									</a>
								</div>
								<div class="width_100 height_30 left" title="Bookmark bài viết">
									<?
									$bookmark_map['operator'][BOOKMARK_ADD]		= BOOKMARK_REMOVE;	// ADD
									$bookmark_map['operator'][BOOKMARK_REMOVE]	= BOOKMARK_ADD;		// REMOVE
									$bookmark_map['icon'][BOOKMARK_ADD]			= '<i class="fa fa-bookmark fa-lg color_orange"></i>';
									$bookmark_map['icon'][BOOKMARK_REMOVE]		= '<i class="fa fa-bookmark-o fa-lg color_orange"></i>';
									
									if ($bookmark != NULL) {
									?>
										<div id="id_bookmark-<?=$Article->a_id?>" class="pointer"
											onclick="ajax_articles_update_bookmark('<?=$bookmark_map['operator'][$bookmark]?>','<?=$Article->a_id?>')">
											<?=$bookmark_map['icon'][$bookmark]?>
											<span class="color_black"> BOOKMARK </span>
										</div>
									<? } else { ?>
										<div class="pointer" onclick="ajax_articles_update_bookmark()"><?=$bookmark_map['icon'][BOOKMARK_REMOVE]?>
											<span class="color_black"> BOOKMARK </span>
										</div>
									<? } ?>
								</div>
							</div>
						</div>
						
						<div class="article_meta_right background_color_light_grey">
							<div class="meta_info_qrcode">
								<div class="article_meta_info_right_ele pointer" id="qrcode"></div>
							</div>
						</div>
					</div>
				
					<article class="article_content" itemprop="articleBody">
						<?=$Article->a_content?>
					</article>

					<div class="article_tag">
						<div class="ele_tag"><i class="fa fa-tags fa-fw"></i> <b>TAGS</b></div>
						<?
							foreach($Article->a_tags as $tag)
							{
								echo '<div class="ele_tag">'.$tag.'</div>';
							}
						?>
					</div>
				</div>
			</div>
			<? } ?>		
			
			<div class="wrapper_content_column_2_element" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<div class="title_base title_color_red"><span><i class="fa fa-user fa-fw"></i> VỀ TÁC GIẢ</span></div>
				<div class="author_about_box">
					<div class="author_icon ico100_avatar_on">
						<a href="/users/index/<?=$Article->a_author_id.'/'.$Article->aa_friendly_url?>">
							<? if($Article->a_isSetAvatar) { ?>
							<img src="/statics/external_users/users/<?=$Article->a_author_id?>/avatar_128.png" width=100 height=100 title="<?=GetNameByOrder($Article->a_first_name, $Article->a_last_name, $Article->a_name_order)?>" itemprop="image"/>
							<? } ?>	
						</a>					
					</div>
						
					<div class="author_about_content">		
						<div class="author_meta">
							<div class="author_meta_left">
								<a class="author_title" href="/users/index/<?=$Article->a_author_id.'/'.$Article->aa_friendly_url?>">
									<span itemprop="name"><?=GetNameByOrder($Article->a_first_name, $Article->a_last_name, $Article->a_name_order)?></span>
								</a>
								<div class="author_job">
									<?=$Article->a_job_title?>
								</div>
							</div>
							<div class="author_meta_right">
								<a class="author_button" href="/users/index/<?=$Article->a_author_id.'/'.$Article->aa_friendly_url?>">HIỂU TÁC GIẢ HƠN</a>
							</div>
						</div>
						<div class="author_description">
							<?=ArticlesCommentsFormat($Article->a_about)?>
						</div>
					</div>
				</div>
			</div>

			<div class="wrapper_content_column_2_element">
				<div class="title_base title_color_lightblue"><span><i class="fa fa-comments fa-fw"></i> THẢO LUẬN</span></div>
				<div class="article_comments">
					<div class="comment_level1_entry">
						<div class="comment_content">
							<div class="comment_left">
								<? if($PROFILE_ID==NULL) { ?>
								<div class="ico50_avatar_off"></div>
								<? } else { ?>
								<div class="ico50_avatar_on">
									<?if ($PROFILE_AVATAR_STATUS) { ?>
										<img src="/statics/external_users/users/<?=$PROFILE_ID?>/avatar_64.png" />
									<? } ?>
								</div>
								<? } ?>
							</div>
							<? if($PROFILE_ID==NULL) { ?>
							<div class="comment_right">
								<a href="/users/join/<?=GetSigninUrlRedirect($SEGMENT_1,$SEGMENT_2)?>">Đăng nhập</a> để cùng nhau thảo luận. <a href="/users/join" target="_blank">Đăng ký</a> ngay nếu bạn chưa có tài khoản.
							</div>
							<? } else { ?>
							<textarea class="comment_right" id="id_articles_comments_level1" maxlength="<?=STRING_MAX_LENGTH?>" placeholder="[SỬ DỤNG TIẾNG VIỆT CÓ DẤU HOẶC TIẾNG ANH] - [Hãy đặt câu hỏi hoặc nêu quan điểm của bạn. Tối thiểu <?=STRING_MIN_LENGTH?> ký tự, tối đa <?=STRING_MAX_LENGTH?> ký tự.]"></textarea>
							<? } ?>
						</div>
						<div class="comment_feature_bar">
							<? if($PROFILE_ID==NULL) { ?>
							<div class="button_wide_disable right">GỬI</div>
							<div class="button_wide right" onclick="STDIO.redirect('/users/join/<?=GetSigninUrlRedirect($SEGMENT_1,$SEGMENT_2)?>')">ĐĂNG NHẬP</div>
							<? } else { ?>
							<div class="button_wide right" onclick="ajax_articles_comments_add(<?=$ARTICLE_ID?>,0)">GỬI</div>	
							<? } ?>
						</div>
						<div class="comment_info_bar">
							<? if ($IsFollowed != NULL) { ?>
							<div class="control_left width_100 height_30 left" title="Theo dõi thảo luận">
								<div id="id_follow-<?=$Article->a_id?>"	class="pointer" onclick="ajax_articles_update_follow_state('<?=$Article->a_id?>')">
									<? if ($IsFollowed == 0) { ?>
										<i class="fa fa-plus-square fa-fw"></i>
										Theo dõi thảo luận
									<? } else { ?>
										<i class="fa fa-minus-square fa-fw"></i>
										Ngừng theo dõi thảo luận
									<? } ?>
								</div>
							</div>
							<? } ?>
							<div class="control_right">
								*Sử dụng <a target="_blank" href="http://bugs.vn">BUGS</a> để chia sẻ mã nguồn trong bình luận</a>
							</div>
						</div>
					</div>
				</div>
				<div class="article_comments" id="id_article_comments_load">
					<div class="loading display_none">
						<i class="fa fa-cog fa-spin fa-2x"></i>
					</div>
				</div>
			</div>
		</div>
	
		<div class="wrapper_content_column_3">
			<div class="wrapper_content_column_element">
				<div class="title_base title_color_darkblue"><span>NỘI DUNG BÀI VIẾT</span></div>
				<div class="anchor_horizontal left" id="id_articles_outline_anchor_id"></div>
				<div class="outline_box" id="id_outline_box_id"></div>
			</div>
		</div>-->
	</div>
</section>