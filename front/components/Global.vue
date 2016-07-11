<style lang="scss">
#styleguide {
background: $body-bg;
&:before, &:after {
  width: auto;
  height: auto;
}

#app {
  max-width: 90%;
  margin: 0 auto;
}

// Global
.sg-main-content {
  max-width: 1300px;
  margin: 2em auto 0 auto;
}

.sg-stack {
  font-family: $font-family-base;
  color: $body-color;
  box-sizing: border-box;
  font-size: 16px;
  
  a {
    color: $body-color;
  }
  
  &::selection {
    background: $gray !important;
    color: $white;
  }
  
  input {
    font-family: "Helvetica Neue", ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Lucida Grande", sans-serif;
    &:focus {
      outline: 1px solid $gray-lighter;
    }
  }
} 

.sg-button {
  text-transform: capitalize;
  border: none;
  background: none;
  font-weight: 700;
  padding: 7px 16px;
  border-radius: 3px;
  color: #373a3c !important;
  font-family: $font-family-base;
  font-size: 12px;
  box-shadow: inset 0 0 1px rgba(0,0,0,.3);
  &.m-small {
    padding: 2px 8px;
  }
  &:hover {
    color: #999 !important;
    box-shadow: inset 0 -10rem 0 rgba(158,158,158,.1);
    svg {
      fill: #999;
    }
  }
  &:focus {
    outline: none;
  }
}

.sg-input {
  &:focus {
    outline: 1px solid #eee;
  }
}

/*
Grid
*/
.container {
  margin: 0 auto;
  width: 80%;
}

.container-fluid {
  margin: 0 auto;
  width: 100%;
}

.sg-row:before,
.sg-row:after {
  display: table;
  line-height: 0;
  content: "";
}

.sg-row:after {
  clear: both;
}

.sg-col-1, .sg-col-2, .sg-col-3, .sg-col-4, .sg-col-5, .sg-col-6,
.sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11, .sg-col-12,
.sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4, .sg-col-offset-5, .sg-col-offset-6,
.sg-col-offset-7, .sg-col-offset-8, .sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
    float: left;
    min-height: 1px;
 }

.box {
  padding: 20px;
}

.box-margin {
  margin: 0 10px 0 10px;
}

.sg-col-1, .sg-col-offset-1 {
  width: 8.33333333333%;
}

.sg-col-2, .sg-col-offset-2 {
  width: 16.6666666666%;
}

.sg-col-3, .sg-col-offset-3 {
  width: 24.9999999999%;
}

.sg-col-4, .sg-col-offset-4 {
  width: 33.3333333333%;
}

.sg-col-5, .sg-col-offset-5 {
  width: 41.6666666666%;
}

.sg-col-6, .sg-col-offset-6 {
  width: 49.9999999999%;
}

.sg-col-7, .sg-col-offset-7 {
  width: 58.3333333333%;
}

.sg-col-8, .sg-col-offset-8 {
  width: 66.6666666666%;
}

.sg-col-9, .sg-col-offset-9 {
  width: 74.9999999999%;
}

.sg-col-10, .sg-col-offset-10 {
  width: 83.3333333333%;
}

.sg-col-11, .sg-col-offset-11 {
  width: 91.6666666666%;
}

.sg-col-12, .sg-col-offset-12 {
  width: 100%;
}

@media only screen and (max-width : 768px) and (min-width : 480px) {
  /*
    Grid
  */
  .container {
    width: 96%;
  }

  .sg-col-1, .sg-col-2, .sg-col-3, .sg-col-5, .sg-col-6,
  .sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11 {
      width: 50%;
  }

  .sg-col-4 {
    width: 33.3333333333%;
  }

  .sg-col-12 {
    width:100%;
  }

  .sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4,
  .sg-col-offset-5, .sg-col-offset-6, .sg-col-offset-7, .sg-col-offset-8,
  .sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
    width: 0% !important;
    display: none;
  }

  .box-margin {
    margin: 0 10px 0 10px;
  }
}

@media only screen and (max-width : 479px) {
  /*
    Grid
  */
  .container {
    width: 96%;
  }

  .sg-col-1, .sg-col-2, .sg-col-3, .sg-col-4, .sg-col-5, .sg-col-6,
  .sg-col-7, .sg-col-8, .sg-col-9, .sg-col-10, .sg-col-11, .sg-col-12 {
      float: none;
      width: 100%;
  }

  .sg-col-offset-1, .sg-col-offset-2, .sg-col-offset-3, .sg-col-offset-4,
  .sg-col-offset-5, .sg-col-offset-6, .sg-col-offset-7, .sg-col-offset-8,
  .sg-col-offset-9, .sg-col-offset-10, .sg-col-offset-11, .sg-col-offset-12 {
    width: 0% !important;
    display: none;
  }

  .box-margin {
    margin: 0 10px 0 10px;
  }
}

.sg-icon {
    width: 12px;
    height: auto;
    fill: #373a3c;
    margin-right: 2px;
    position: relative;
    top: 2px;
  &:hover {
    fill: #666;
  }
}

code,
code[class*='language-'],
pre[class*='language-'] {
  color: $body-color;
  text-align: left;
  white-space: pre;
  word-spacing: normal;
  tab-size: 4;
  hyphens: none;
  font-family: $font-family-mono;
  line-height: 1.4;
  direction: ltr;
  cursor: text;
  border: none;
  
  &::selection {
    background: $gray !important;
    color: $white;
  }
}

pre[class*='language-'] {
  overflow: auto;
  margin: 1em 0;
  padding: 1.2em;
  border-radius: 3px;
  font-size: 85%;
}

pre[class*='language-']:focus {
  outline: none;
}

p code,
li code,
table code {
  margin: 0;
  border-radius: 3px;
  padding: 0.2em 0;
  font-size: 85%;
}
p code:before, p code:after,
li code:before,
li code:after,
table code:before,
table code:after {
  letter-spacing: -0.2em;
  content: '\00a0';
}

code,
:not(pre) > code[class*='language-'],
pre[class*='language-'] {
  background: #f7f7f7;
}

:not(pre) > code[class*='language-'] {
  padding: 0.1em;
  border-radius: 0.3em;
}

.token::selection {
  background: $gray;
  color: $white !important;
}

.token.comment, .token.prolog, .token.doctype, .token.cdata {
  color: #969896;
}
.token.punctuation, .token.string, .token.atrule, .token.attr-value {
  color: #183691;
}
.token.property, .token.tag {
  color: #63a35c;
}
.token.boolean, .token.number {
  color: #0086b3;
}
.token.selector, .token.attr-name, .token.attr-value .punctuation:first-child, .token.keyword, .token.regex, .token.important {
  color: #a71d5d;
}
.token.operator, .token.entity, .token.url, .language-css .token.string {
  color: #a71d5d;
}
.token.entity {
  cursor: help;
}

.namespace {
  opacity: 0.7;
}
}
</style>