<style>
/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: italic;
    font-weight: 300;
    src: local('Roboto Light Italic'),
    local('Roboto-LightItalic'),
    url(fonts/roboto/Roboto-lightitalic-webfont.woff) format('woff');

}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: italic;
    font-weight: 400;
    src: local('Roboto Italic'),
    local('Roboto-Italic'),
    url(fonts/roboto/Roboto-italic-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: italic;
    font-weight: 700;
    src: local('Roboto Bold Italic'),
    local('Roboto-BoldItalic'),
    url(fonts/roboto/Roboto-bolditalic-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: italic;
    font-weight: 900;
    src: local('Roboto Black Italic'),
    local('Roboto-BlackItalic'),
    url(fonts/roboto/Roboto-blackitalic-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 300;
    src: local('Roboto Light'),
    local('Roboto-Light'),
    url(fonts/roboto/Roboto-light-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    src: local('Roboto Regular'),
    local('Roboto-Regular'),
    url(fonts/roboto/Roboto-regular-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 700;
    src: local('Roboto Bold'),
    local('Roboto-Bold'),
    url(fonts/roboto/Roboto-bold-webfont.woff) format('woff');
}

/* latin */
@font-face {
    font-family: 'Roboto';
    font-style: normal;
    font-weight: 900;
    src: local('Roboto Black'),
    local('Roboto-Black'),
    url(fonts/roboto/Roboto-black-webfont.woff) format('woff');
}

.sp-dsgvo-popup-overlay,
.sp-dsgvo-cookie-overlay {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(34, 34, 34, .8);
    z-index: 9999999;
}

.sp-dsgvo-privacy-popup{
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 500px;
    /*height: calc(100% - 100px);*/
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 22px;
    padding-bottom: 10px;
    padding-left: 5px !important;
    padding-right: 5px !important;
    line-height: initial;
    background-color: white;
    color: black;
}

@media (max-width: 540px) {

    .sp-dsgvo-privacy-popup {
        max-width: 360px;
       /* max-height: 635px;*/
    }

}

@media (min-width: 541px) {

    .sp-dsgvo-privacy-popup {
        max-width: 600px;
    }

}

.sp-dsgvo-popup-overlay.sp-dsgvo-overlay-hidden {
    display: none;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-popup-top{
    padding: 20px 10px 10px 10px;
    box-sizing:  border-box;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-popup-more-information-top
{
    padding: 10px;
    height: 50px;
    box-sizing:  border-box;
}

.sp-dsgvo-popup-close,
.sp-dsgvo-popup-more-information-close {
    height: 10px;
}

.sp-dsgvo-popup-close svg{
    vertical-align: top;
}

.sp-dsgvo-popup-more-information-close svg{
    vertical-align: middle;
}

.sp-dsgvo-popup-close svg line,
.sp-dsgvo-popup-more-information-close svg line{
    stroke-width: 2px;
    stroke: #000000;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-logo-wrapper {
    width: 40px;
    float: left;
    margin-right: 5px;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-logo-wrapper img {
    max-height: 35px;
    max-width: 35px;
    position: relative;
}

@media (max-width: 480px) {

    .sp-dsgvo-privacy-popup .sp-dsgvo-logo-wrapper img{
        max-width: 100px;
    }

}

.sp-dsgvo-header-description-text {
    font-size: 0.65em;
}


.sp-dsgvo-privacy-popup .sp-dsgvo-link-wrapper
{

}

.sp-dsgvo-privacy-popup .sp-dsgvo-link-wrapper a,
.sp-dsgvo-privacy-popup .sp-dsgvo-link-wrapper span
{
    font-size: 0.5em;
    font-weight:bold;
    color: #555555;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-dropdown  {
    display: none;
    position: absolute;
    left: 0;
    top: calc(100% + 10px);
    width: 100%;
    border: 1px solid #f1f1f1;
    background-color: #ffffff;
    border-radius: 5px;
    z-index: 10;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-wrapper {
    display: flex;
    justify-content: flex-end;
}

.sp-dsgvo-privacy-popup .dsgvo-lang-active  {
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: flex-start;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-active span  {
    width: calc(100% - 38px);
}

.sp-dsgvo-privacy-popup .sp-dsgvo-popup-language-switcher  {
    position: relative;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-popup-language-switcher  span{
    font-size: 0.75em;
}


.sp-dsgvo-privacy-popup .sp-dsgvo-lang-active img  {
    margin-right: 5px;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-active svg  {
    margin-left: 3px;
    vertical-align: middle;
}

@media (max-width: 540px) {
    .sp-dsgvo-privacy-popup .sp-dsgvo-lang-active svg  {
        margin-top: 5px;
        vertical-align: top;
    }
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-active svg line  {
    stroke-width: 2px;
    stroke: #000000;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-dropdown.active  {
    display: block;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-dropdown a,
.sp-dsgvo-privacy-popup .sp-dsgvo-lang-dropdown a span{
    width: 100%;
    font-size: 0.6em;
    font-weight: 500;
    align-items: center;
    padding: 3px;
    color: black;
}

.sp-dsgvo-privacy-popup .sp-dsgvo-lang-dropdown a img  {
    margin-right: 5px;
    padding-left: 3px;
}

.sp-dsgvo-privacy-category-content,
.sp-dsgvo-popup-more-information-content{
    /*height: calc(100% - 145px);*/
    overflow-y: auto;
    overflow-x: hidden;
}

@media (max-width: 540px) {

    .sp-dsgvo-privacy-category-content {
       overflow-y: scroll;
        max-height: 412px;
    }

    .sp-dsgvo-popup-more-information-content {
        overflow-y: scroll;
        max-height: 330px;
    }

}


.sp-dsgvo-privacy-popup p,
.sp-dsgvo-privacy-popup span{
    font-size: 0.7em;

}

.sp-dsgvo-popup-more-information-content p,
.sp-dsgvo-popup-more-information-content span{
    font-size: 0.6em;
    margin: 0;
}

@media (max-height: 568px)  {
  .sp-dsgvo-privacy-content-category-content
  {
      max-height: 270px !important;
  }
  .sp-dsgvo-popup-more-information-content
  {
      max-height: 310px !important;
  }
}

@media (min-height: 569px) and (max-height: 667px)  {
    .sp-dsgvo-privacy-content-category-content
    {
        max-height: 370px !important;
    }
}

@media (min-height: 668px)  {
    .sp-dsgvo-privacy-content-category-content
    {
        max-height: 430px !important;
    }
}


.sp-dsgvo-privacy-popup-title {
    font-size: 1.0em;
    font-weight: 500;
    margin-bottom: 0;
}

.sp-dsgvo-privacy-content {
    padding: 10px;
}

.sp-dsgvo-category-container {
    border-radius: 3px;
    background-color: #F0F0F0;
    padding: 10px 15px 10px 15px;
    margin-bottom: 5px;
}

.sp-dsgvo-category-name,
.sp-dsgvo-popup-more-information-title{
    font-size: 0.8em;
    font-weight: bold;
}

.sp-dsgvo-category-name small{
    font-size: 75%;
    font-weight: 400;
}

.sp-dsgvo-category-count {
    font-size: 0.7em;
    width: 80px;
}

.sp-dsgvo-category-description {
    font-size: 0.6em;

}
.sp-dsgvo-category-toggle {

}

.sp-dsgvo-category-item
{
    margin-left: 10px;
    margin-top:5px;
    margin-bottom: 5px;
}

.sp-dsgvo-category-item-name
{
    font-size: 0.7em;
    font-weight: bold;
}

.sp-dsgvo-category-item-name small
{
    font-size: 70%;
    font-weight: 600;
}

.sp-dsgvo-category-item-company
{
    font-size: 0.60em;
}

.sp-dsgvo-category-item-description-url
{

}

.sp-dsgvo-category-item-description-url a
{
    font-size: 0.6em;
    color: #006d91 !important;
}


.sp-dsgvo-category-item-toggle {

}

.sp-dsgvo-category-container hr {
    margin: 1px 0px 1px 0px !important;
    height:1px;
    border:none;
    color:white;
    background-color:white;
}

.sp-dsgvo-category-item-toggle input[type=checkbox],
.sp-dsgvo-category-toggle input[type=checkbox]{
    height: 0;
    width: 0;
    visibility: hidden;
    display: block;
}

.sp-dsgvo-category-item-toggle label,
.sp-dsgvo-category-toggle label{
    margin-bottom: 0;
}


.sp-dsgvo-category-item-toggle > .switch,
.sp-dsgvo-category-toggle > .switch {
    display: block;
    margin-bottom: 5px;
}

.switch {
    position: relative;
    display: inline-block;
    vertical-align: top;
    width: 65px;
    height: 24px;
    padding: 2px;
    cursor: pointer;
    border-radius: 18px;
    /*

    background-color: white;
        box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
        background-image: -webkit-linear-gradient(top, #eeeeee, white 25px);
        background-image: -moz-linear-gradient(top, #eeeeee, white 25px);
        background-image: -o-linear-gradient(top, #eeeeee, white 25px);
        background-image: linear-gradient(to bottom, #eeeeee, white 25px);
     */
}

.switch-input {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}

.switch-label {
    position: relative;
    display: block;
    height: 20px;
    font-size: 11px !important;
    text-transform: uppercase;
    background: #eceeef;
    border-radius: inherit;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
    -webkit-transition: 0.15s ease-out;
    -moz-transition: 0.15s ease-out;
    -o-transition: 0.15s ease-out;
    transition: 0.15s ease-out;
    -webkit-transition-property: opacity background;
    -moz-transition-property: opacity background;
    -o-transition-property: opacity background;
    transition-property: opacity background;
}
.switch-label:before, .switch-label:after {
    position: absolute;
    top: 50%;
    margin-top: -.5em;
    line-height: 1;
    -webkit-transition: inherit;
    -moz-transition: inherit;
    -o-transition: inherit;
    transition: inherit;
}
.switch-label:before {
    content: attr(data-off);
    right: 11px;
    color: #aaa;
    text-shadow: 0 1px rgba(255, 255, 255, 0.5);
}
.switch-label:after {
    content: attr(data-on);
    left: 11px;
    color: white;
    text-shadow: 0 1px rgba(0, 0, 0, 0.2);
    opacity: 0;
}
.switch-input:checked ~ .switch-label {
    background: #47a8d8;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
}
.switch-input:checked ~ .switch-label:before {
    opacity: 0;
}
.switch-input:checked ~ .switch-label:after {
    opacity: 1;
}

.switch-handle {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 17px;
    height: 17px;
    background: white;
    border-radius: 10px;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
    background-image: -webkit-linear-gradient(top, white 40%, #f0f0f0);
    background-image: -moz-linear-gradient(top, white 40%, #f0f0f0);
    background-image: -o-linear-gradient(top, white 40%, #f0f0f0);
    background-image: linear-gradient(to bottom, white 40%, #f0f0f0);
    -webkit-transition: left 0.15s ease-out;
    -moz-transition: left 0.15s ease-out;
    -o-transition: left 0.15s ease-out;
    transition: left 0.15s ease-out;
}
.switch-handle:before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -6px 0 0 -6px;
    width: 12px;
    height: 12px;
    background: #f9f9f9;
    border-radius: 6px;
    box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
    background-image: -webkit-linear-gradient(top, #eeeeee, white);
    background-image: -moz-linear-gradient(top, #eeeeee, white);
    background-image: -o-linear-gradient(top, #eeeeee, white);
    background-image: linear-gradient(to bottom, #eeeeee, white);
}
.switch-input:checked ~ .switch-handle {
    left: 40px;
    box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
}

.switch-green > .switch-input:checked ~ .switch-label {
    background: #4fb845;
}

.sp-dsgvo-popup-bottom
{

}
.sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button
{
    text-transform: uppercase;
    font-size: 0.62em;
    font-weight: 500;
    padding: 6px 11px 6px 11px;
    display:  inline-block;
    margin-left: 10px;
    margin-right: 10px;
    position: relative;
    box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
    border-radius: 3px;
}
.sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button:hover,
.sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button:focus,
.sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button:active
{
    text-decoration: none;
}

@media (max-width: 540px) {

    .sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button
    {
        margin-left: 0px;
        margin-right: 0px;
        text-align: center;
        font-size: 0.55em;
    }

}

.sp-dsgvo-privacy-bottom  a.grey
{
    color: white;
    border-color: #4d4c53;
    background-color: #4d4c53;
}

.sp-dsgvo-privacy-bottom  a.blue
{
    color: white;
    border-color: #27A1E5;
    background-color: #27A1E5;
}

.sp-dsgvo-privacy-bottom  a.green
{
    color: white;
    border-color: #4fb845;
    background-color: #4fb845;
}

.sp-dsgvo-privacy-bottom  a.sp-dsgvo-popup-button:hover
{
    color: #555555;
}

.sp-dsgvo .progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: 10px;
    overflow: hidden;
    font-size: 0.703125rem;
    background-color: #ccc;
    border-radius: 0px;
}
.sp-dsgvo .progress-bar-animated {
    -webkit-animation: progress-bar-stripes 1s linear infinite;
    animation: progress-bar-stripes 1s linear infinite;
}
.sp-dsgvo .progress-bar-striped {
    background-image: linear-gradient(45deg, rgba(255,255,255,0.15) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.15) 75%, transparent 75%, transparent);
    background-size: 1rem 1rem;
}
.sp-dsgvo .progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #999;
    -webkit-transition: width 0.6s ease;
    transition: width 0.6s ease;
    font-size: 12px;
    font-weight: 500;
}

@-webkit-keyframes progress-bar-stripes {
    from {
        background-position: 1rem 0;
    }
    to {
        background-position: 0 0;
    }
}

@keyframes progress-bar-stripes {
    from {
        background-position: 1rem 0;
    }
    to {
        background-position: 0 0;
    }
}
</style>