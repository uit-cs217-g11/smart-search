<section class="wrapper_section wrapper_content">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">

		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
				<div class="developers">Nhóm phát triển</div>
				<div class="table">
				<?php foreach($developers as $item) { ?>
					<div class="row">
						<?php $user_avatar = URL_HOME.'/statics/external_data/developers/'.$item->id.'_avatar_256.png?'.time(); ?>
						<a class="avatar" style="background:url('<?=$user_avatar?>')" href="<?=$item->url?>"></a>
						
						<a class="name" href="<?=$item->url?>"><?=$item->first_name . CHAR_SPACE . $item->last_name?></a>
						
						<div class="info">
							<div class="info_title">Giới thiệu về bản thân</div>
							<div class="content"><?=$item->description?></div>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		
		<div class="wrapper_content_column_3">

		</div>
	</div>
</section>