<template>
  <nav class="sg-nav sg-stack">
    <ul class="sg-nav-links">
      <li v-for="section in sections">
          <a href="#{{ section.slug }}">{{ section.title }}</a>
          <ul class="sg-nav-sublinks">
            <li v-for="style in section.styles">
              <a href="#{{ style.slug }}">{{ style.title }}</a>
            </li>
          </ul>
      </li>
  </nav>
</template>

<script>
export default {
  props: {
    sections: Array
  }
}