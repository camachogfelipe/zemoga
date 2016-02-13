<?php
if(isset($_GET['type'])) :
	require( __DIR__ . '/../../../../wp-load.php');
	$data = centro_get_contacts($_GET['type']);
	$data_keys = array(//"id" => "id", 
					   "slug" => "linkURL", 
					   "image" => "imageURL", 
					   "name" => "title",
					   "title" => "imageAlt",
					   "bio" => "bio",
					   "order" => "order"
					  );
	foreach($data as $key => $dato) :
		foreach($dato as $k=>$v) :
			if(isset($data_keys[$k])) :
				$datos[$key][$data_keys[$k]] = $v;
			endif;
		endforeach;
		$datos[$key]['linkContent'] = $dato['title'];
	endforeach;
	$datos = orderMultiDimensionalArray($datos, "order", false);
	header("Content-type: text/plain; charset=utf-8");
	if(count($datos) > 1) echo '{"data": '.json_encode($datos).'}';
	elseif(count($datos) == 1) echo '{"data": ['.json_encode($datos).'}]';
endif;
?>