<?php
/**
 * Template for the /styleguide route.
 * 
 */
?>


<?php wp_head(); ?>

<body id="styleguide">
	<div id="app">
		<section class="sg-section" v-for="section in all_sections">
				<h2>{{ section.title }}</h2>
				<div class="sg-container" v-for="style in section.styles">
					<h3 class="sg-title">{{ style.title }}</h3>
					<div class="sg-output">
							{{{ style.html }}}
					</div>
					<p>Example Code:</p>
					<div class="sg-markup">
						<pre>{{ style.html }}</pre>
					</div>
				</div>
		</section>
	</div>
<?php wp_footer(); ?>
</body>
