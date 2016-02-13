<?php
$crfilt = (get_query_var('crfilt')) ? get_query_var('crfilt') : 'all';
$crpage = (get_query_var('crpage')) ? get_query_var('crpage') : 1;

$link_cats = get_terms('link_category');
$crverts = array();
$crtypes = array();
$crids = array();
$ccats_by_id = array();
$ccats_by_slug = array();
foreach($link_cats as $lc) {
	if (preg_match('/^cv\-/', $lc->slug)) {
		$crverts[] = $lc;
		$crids[] = $lc->term_id;
		$ccats_by_id[$lc->term_id] = $lc;
		$ccats_by_slug[$lc->slug] = $lc;
	}
	if (preg_match('/^ct\-/', $lc->slug)) {
		$crtypes[] = $lc;
		$crids[] = $lc->term_id;
		$ccats_by_id[$lc->term_id] = $lc;
		$ccats_by_slug[$lc->slug] = $lc;
	}
}
?>
<?php get_header(); ?>
<div class="template-content template-creatives">
			<p>
				<a href="/creatives/">Show All</a>
				| Filter by Creative Format:
		    	<select class="filter">
			    	<option value="">Choose Format</option>
			    	<?php foreach($crtypes as $lc): ?>
			    	<option value="<?php echo preg_replace('/^c[tv]\-/', '/creatives/format/', $lc->slug); ?>"><?php echo preg_replace('/^C[TV] /', '', $lc->name); ?></option>
			    	<?php endforeach; ?>
			    </select>
		    	| Filter by Vertical
	    		<select class="filter">
		    		<option value="">Choose Vertical</option>
		    		<?php foreach($crverts as $lc): ?>
		    		<option value="<?php echo preg_replace('/^c[tv]\-/', '/creatives/vertical/', $lc->slug); ?>"><?php echo preg_replace('/^C[TV] /', '', $lc->name); ?></option>
		    		<?php endforeach; ?>
		    	</select>
			</p>
<?php
$links = ($crfilt == 'all') ? get_bookmarks(array('category' => implode(',', $crids))) : get_bookmarks(array('category' => $ccats_by_slug[$crfilt]->term_id));
$title = ($crfilt == 'all') ? "Creative Showcase" : preg_replace('/^C[TV] /', '', $ccats_by_slug[$crfilt]->name);
$rows = array();
foreach ($links as $l) {
	if (! array_key_exists($l->link_id, $rows)) {
		$rows[$l->link_id] = array();
		$rows[$l->link_id]['formats'] = array();
		$rows[$l->link_id]['verticals'] = array();
		$link_detail = get_bookmark($l->link_id);
		foreach ($link_detail->link_category as $c) {
			if (preg_match('/^ct\-/', $ccats_by_id[$c]->slug))
				$rows[$l->link_id]['formats'][] = preg_replace('/^C[TV] /', '', $ccats_by_id[$c]->name);
			if (preg_match('/^cv\-/', $ccats_by_id[$c]->slug))
				$rows[$l->link_id]['verticals'][] = preg_replace('/^C[TV] /', '', $ccats_by_id[$c]->name);
		}
		$rows[$l->link_id]['client'] = $l->link_name;
		$rows[$l->link_id]['url'] = $l->link_url;
	}
}
?>
<h3><?php echo $title; ?></h3>
<p><?php the_content(); ?></p>
		<table class="crlinks">
		<tr>
			<th><h4>Advertisers</h4></th>
			<th><h4>Formats</h4></th>
			<th><h4>Verticals</h4></th>
		</tr>
		<?php foreach ($rows as $r): ?>
		<tr>
			<td><a href="<?php echo $r['url']; ?>"><?php echo $r['client']; ?></a></td>
			<td><?php echo implode(',', $r['formats']); ?></td>
			<td><?php echo implode(',', $r['verticals']); ?></td>
		</tr>
		<?php endforeach; ?>
		</table>
</div>

<?php get_footer(); ?>
