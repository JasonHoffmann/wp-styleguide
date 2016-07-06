<style lang="scss">
#styleguide {
background: #f7f7f7;
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
  font-family: ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Helvetica Neue", "Lucida Grande", sans-serif;
  color: #333;
  box-sizing: border-box;
  font-size: 16px;
  
  a {
    color: #666;
  }
  
  &::selection {
    background: #333;
    color: white;
  }
  
  input {
    font-family: ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Helvetica Neue", "Lucida Grande", sans-serif;
    &:focus {
      outline: 1px solid black;
    }
  }
} 

.sg-button {
  text-transform: uppercase;
  border: none;
  background: none;
  font-weight: 700;
  padding: 10px 0;
  border-radius: 3px;
  color: #333 !important;
  font-family: ".SFNSText-Regular", "San Francisco", "Roboto", "Segoe UI", "Helvetica Neue", "Lucida Grande", sans-serif;
  font-size: 12px;
  &:hover {
    color: #666 !important;
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
    width: 14px;
    height: auto;
    fill: #333;
    margin-right: 2px;
    position: relative;
    top: 3px;
  &:hover {
    fill: #666;
  }
}

code,
code[class*='language-'],
pre[class*='language-'] {
  color: #333;
  text-align: left;
  white-space: pre;
  word-spacing: normal;
  tab-size: 4;
  hyphens: none;
  font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace;
  line-height: 1.4;
  direction: ltr;
  cursor: text;
}

pre[class*='language-'] {
  overflow: auto;
  margin: 1em 0;
  padding: 1.2em;
  border-radius: 3px;
  font-size: 85%;
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