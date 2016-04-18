<?php if (!is_page_template( 'template-contact.php' )) : // Check if not contact-page ?>

<aside class="footer-banner box-colored">
	<div class="wrap">

		<?php
		/* Get Call To Action Data */
        $ejo_call_to_action = get_post_meta( get_the_ID(), '_ejo-call-to-action', true ); 

        $cta_title = (!empty($ejo_call_to_action['title'])) ? $ejo_call_to_action['title'] : 'Meer weten over het laten maken van een website?';
        $cta_text = (!empty($ejo_call_to_action['text'])) ? $ejo_call_to_action['text'] : '';
        $cta_post_id = (!empty($ejo_call_to_action['post_id'])) ? $ejo_call_to_action['post_id'] : '51';
        $cta_link_text = (!empty($ejo_call_to_action['link_text'])) ? $ejo_call_to_action['link_text'] : 'Contact opnemen';
		?>

		<h2 <?php hybrid_attr( 'entry-title' ); ?>><?php echo $cta_title; ?></h2>

		<a href="<?php echo get_permalink($cta_post_id); ?>" class="button highlight"><?php echo $cta_link_text; ?></a>

	</div>
</aside>

<?php endif; // End contact-page check ?>