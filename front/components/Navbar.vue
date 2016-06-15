<template>
  <nav class="sg-nav sg-stack sg-col-3">
    <ul class="sg-nav-links">
      <li class="sg-nav-link sg-nav-link__parent" v-for="section in sections">
          <a class="sg-nav-link--link" href="#{{ section.slug }}">{{ section.title }}</a>
          <ul class="sg-nav-links sg-nav-sublinks">
            <li class="sg-nav-link sg-nav-link__child" v-for="style in section.styles">
              <a class="sg-nav-link--link" href="#{{ style.slug }}">{{ style.title }}</a>
            </li>
          </ul>
      </li>
  </nav>
</template>

<style lang="scss">
#styleguide {
	.sg-nav-links {
		list-style: none;
		margin: 0;
		padding: 1em;
		font-size: 13px;
		font-weight: normal;
	}
	
	.sg-nav-link {
		list-style: none;
		a {
			display: block;
			width: 100%;
			padding: 10px;
			box-sizing: border-box;
			border-radius: 5px;
		}
	}
	
	.sg-nav-sublinks {
		padding: 0;
		padding-left: 10px;
		font-size: 13px;
	}
	
	.sg-nav-link--link:hover {
		background: #eee;
	}
}
</style>

<script>
export default {
  props: {
    sections: Array
  }
}
</script>