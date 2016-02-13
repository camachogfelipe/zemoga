<?php
if(!empty($grid_data)) :
	$i = 0;
	foreach($grid_data as $grid_item) :
		echo "<!-- grid item -->";
		echo '<td>';
		if(isset($grid_item['link']) and !empty($grid_item['link'])) :
			echo '<a href="'.$grid_item['link'].'"';
			if($modal == true) echo ' class="is-modal"';
			echo '>';
		endif;
		echo '<figure>';
		echo '<img src="'.$grid_item['image'].'" alt="'.$grid_item['post_title'].'" width="230" height="170">';
		echo '<figcaption>';
		echo '<h4>'.$grid_item['post_name'].'</h4>';
		echo '<h5>'.$grid_item['subtitle'].'</h5>';
		echo '</figcaption>';
		if(!empty($grid_item['post_content']) and $modal == true) :
			echo '<div class="hidden-grid-field post-content">'.$grid_item['post_content'].'</div>';
		endif;
		echo '</figure>';
		if(isset($grid_item['link']) and !empty($grid_item['link'])) echo '</a>';
		echo '</td>';
		if ($i % 3 == 2) :
			echo '</tr><tr>';
		endif;
		$i++;
		echo '<!-- END grid item -->';
	endforeach;
endif;
?>