<section class="wrapper_section wrapper_content">
	<div class="wrapper_section_center wrapper_content_center">
		<div class="wrapper_content_column_1">
			
		</div>
		
		<div class="wrapper_content_column_2">
			<div class="wrapper_content_column_2_element">
			<?php
			foreach ($categories as $item1)
			{
				if ($item1->parent_id == 0)
				{
					echo '<h4>', $item1->category_name, '</h4>';
					echo '<div class="sitemap_category_list">';
			
					foreach ($categories as $item2)
					{
						if ($item2->parent_id == $item1->id)
						{
							echo	'<a href="'.URL_HOME.'/articles/category/', $item2->id, '/' , $item2->friendly_url , '">',
										'<div class="sitemap_category_element">',
											$item2->category_name,
									'</div></a>';
						}
					}		
					echo '</div>';
				}
			}
			?>
			</div>
		</div>
		
		<div class="wrapper_content_column_3">

		</div>	
	</div>
</section>
