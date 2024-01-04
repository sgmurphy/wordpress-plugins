import { useState } from "@wordpress/element";
import {
    typoPrefix_content,
    typoPrefix_title,
} from "./constants/typographyPrefixConstants";

import {
    //
    WrpMarginConst,
    WrpPaddingConst,
    contentPaddingConst,
    titlePaddingConst,
} from "./constants/dimensionsConstants";

import {
    //
    WrpBdShadowConst,
} from "./constants/borderShadowConstants";

import { wrapMaxWidthPrefix } from "./constants/rangeNames";

const {
    softMinifyCssStrings,
    generateDimensionsControlStyles,
    generateTypographyStyles,
    generateBorderShadowStyles,
    generateResponsiveRangeStyles,
    StyleComponent
} = window.EBControls;

export default function Style(props) {
    const { attributes, setAttributes, name } = props;
    const {
        resOption,
        blockId,
        blockMeta,
        collapsible,
        listType,
        titleBg = "#ff7d50",
        titleColor = "#fff",
        contentBg = "#fff6f3",
        contentColor = "#707070",
        mainBgc,
        contentHoverColor,
        titleAlign,
        seperator,
        seperatorSize,
        seperatorColor = "#000",
        seperatorStyle,
        scrollToTop,
        arrowHeight,
        arrowWidth,
        arrowBg,
        arrowColor,
        contentAlign,
        isSticky,
        topSpace,
        contentHeight,
        indent,
        hasUnderline,
        contentGap = "20",
        contentGapUnit = "px",
        listSeperatorWidth = 3,
        listSeperatorStyle = "solid",
        listSeperatorColor = "#000",
        showListSeparator,
        classHook,
    } = attributes;

    const [visible, setVisible] = useState(true);

    // // styles related to generateResponsiveRangeStyles start ⬇
    const {
        rangeStylesDesktop: wrapMaxWidthDesktop,
        rangeStylesTab: wrapMaxWidthTab,
        rangeStylesMobile: wrapMaxWidthMobile,
    } = generateResponsiveRangeStyles({
        controlName: wrapMaxWidthPrefix,
        property: "max-width",
        attributes,
    });

    // // styles related to generateTypographyStyles start ⬇
    const {
        typoStylesDesktop: titleTypoStylesDesktop,
        typoStylesTab: titleTypoStylesTab,
        typoStylesMobile: titleTypoStylesMobile,
    } = generateTypographyStyles({
        attributes,
        prefixConstant: typoPrefix_title,
        defaultFontSize: 22,
    });

    const {
        typoStylesDesktop: contentTypoStylesDesktop,
        typoStylesTab: contentTypoStylesTab,
        typoStylesMobile: contentTypoStylesMobile,
    } = generateTypographyStyles({
        attributes,
        prefixConstant: typoPrefix_content,
        defaultFontSize: 20,
    });
    // // styles related to generateTypographyStyles end

    // // styles related to generateDimensionsControlStyles start ⬇
    const {
        dimensionStylesDesktop: wrpMarginDesktop,
        dimensionStylesTab: wrpMarginTab,
        dimensionStylesMobile: wrpMarginMobile,
    } = generateDimensionsControlStyles({
        attributes,
        controlName: WrpMarginConst,
        styleFor: "margin",
    });

    const {
        dimensionStylesDesktop: wrpPaddingDesktop,
        dimensionStylesTab: wrpPaddingTab,
        dimensionStylesMobile: wrpPaddingMobile,
    } = generateDimensionsControlStyles({
        attributes,
        controlName: WrpPaddingConst,
        styleFor: "padding",
    });

    const {
        dimensionStylesDesktop: titlePaddingDesktop,
        dimensionStylesTab: titlePaddingTab,
        dimensionStylesMobile: titlePaddingMobile,
    } = generateDimensionsControlStyles({
        attributes,
        controlName: titlePaddingConst,
        styleFor: "padding",
    });

    const {
        dimensionStylesDesktop: contentPaddingDesktop,
        dimensionStylesTab: contentPaddingTab,
        dimensionStylesMobile: contentPaddingMobile,
    } = generateDimensionsControlStyles({
        attributes,
        controlName: contentPaddingConst,
        styleFor: "padding",
    });

    // // styles related to generateDimensionsControlStyles end

    // // styles related to generateBorderShadowStyles start ⬇
    const {
        styesDesktop: wrpBdShdStyesDesktop,
        styesTab: wrpBdShdStyesTab,
        styesMobile: wrpBdShdStyesMobile,
        stylesHoverDesktop: wrpBdShdStylesHoverDesktop,
        stylesHoverTab: wrpBdShdStylesHoverTab,
        stylesHoverMobile: wrpBdShdStylesHoverMobile,
        transitionStyle: wrpBdShdTransitionStyle,
    } = generateBorderShadowStyles({
        controlName: WrpBdShadowConst,
        attributes,
        // noShadow: true,
        // noBorder: true,
    });

    // // styles related to generateBorderShadowStyles end

    const desktopAllStylesCommon = `
		  ${isSticky
            ? `
			  .eb-parent-${blockId}.eb__animated, .eb__animated.eb__flip {
				  -webkit-animation-fill-mode: none;
				  animation-fill-mode: none;
				  -webkit-animation-name: none;
				  animation-name: none !important;
			  }
		  `
            : ""
        }

		  .${blockId}.eb-toc-container{
			  ${wrapMaxWidthDesktop}

			  ${mainBgc ? `background-color:${mainBgc};` : ""}

			  ${wrpMarginDesktop}
			  ${wrpPaddingDesktop}
			  ${wrpBdShdStyesDesktop}
			  ${isSticky ? "" : `transition:all 0.5s, ${wrpBdShdTransitionStyle}`};
		  }

		  .${blockId}.eb-toc-container:hover{
			  ${wrpBdShdStylesHoverDesktop}
		  }

		  .${blockId}.eb-toc-container .eb-toc-title{
			  text-align: ${titleAlign};
			  cursor:${collapsible ? "pointer" : "default"};
			  color: ${titleColor};
			  background-color:${titleBg};
			  ${seperator
            ? `border-bottom:${seperatorSize || 0
            }px ${seperatorStyle} ${seperatorColor};`
            : ""
        }
			  ${titlePaddingDesktop}
			  ${titleTypoStylesDesktop}

		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper{
			  background-color:${contentBg};
			  text-align: ${contentAlign};
			  ${contentPaddingDesktop}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper ul,
		  .${blockId}.eb-toc-container .eb-toc-wrapper ol
		  {
			  ${listType === "none" ? `list-style: none;` : ""}
			  ${indent ? `margin-left:${indent}px;` : ""}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper li {
			  color:${contentColor};
			  ${contentTypoStylesDesktop}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper li:hover{
			  color:${contentHoverColor};
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper li a{
			  color:inherit;
		  }


		  .${blockId}.eb-toc-container .eb-toc-wrapper li a,
		  .${blockId}.eb-toc-container .eb-toc-wrapper li a:focus{
			  ${!hasUnderline ? "text-decoration:none;" : "text-decoration:underline;"}
			  background:none;
		  }

		  ${scrollToTop
            ? `
			  .eb-toc-go-top.show-scroll {
				  ${arrowHeight ? `height: ${arrowHeight}px;` : ""}
				  ${arrowWidth ? `width: ${arrowWidth}px;` : ""}
				  ${arrowBg ? `background-color: ${arrowBg};` : ""}
				  ${arrowColor ? `color: ${arrowColor};` : ""}
			  }
			  `
            : // Important N.B. : in the selector above we used ".eb-toc-go-top.show-scroll" this. It's very important to start the selector with ".eb-" if this css strings goes inside "softMinifyCssStrings" function. Always make sure to use a selector that starts with ".eb-" when using this string inside "softMinifyCssStrings" function
            ""
        }

        .${blockId}.eb-toc-container .eb-toc-wrapper li {
            padding-top: ${contentGap / 2}${contentGapUnit};
        }

        .${blockId}.eb-toc-container .eb-toc-wrapper .eb-toc__list li:not(:last-child) {
            padding-bottom: ${contentGap / 2}${contentGapUnit};
        }

        ${showListSeparator
            ? `
                .${blockId}.eb-toc-container .eb-toc-wrapper .eb-toc__list li:first-child {
                    border-bottom: ${listSeperatorWidth}px ${listSeperatorStyle} ${listSeperatorColor};
                }
        `
            : ""
        }

	  `;

    const tabAllStylesCommon = `
		  .${blockId}.eb-toc-container{
			  ${wrapMaxWidthTab}

			  ${wrpMarginTab}
			  ${wrpPaddingTab}
			  ${wrpBdShdStyesTab}
		  }
		  .${blockId}.eb-toc-container:hover{
			  ${wrpBdShdStylesHoverTab}
		  }

		  .${blockId}.eb-toc-container .eb-toc-title{
			  ${titlePaddingTab}
			  ${titleTypoStylesTab}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper{
			  ${contentPaddingTab}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper li{
			  ${contentTypoStylesTab}
		  }

	  `;

    const mobileAllStylesCommon = `
		  .${blockId}.eb-toc-container{
			  ${wrapMaxWidthMobile}


			  ${wrpMarginMobile}
			  ${wrpPaddingMobile}
			  ${wrpBdShdStyesMobile}
		  }

		  .${blockId}.eb-toc-container:hover{
			  ${wrpBdShdStylesHoverMobile}
		  }

		  .${blockId}.eb-toc-container .eb-toc-title{
			  ${titlePaddingMobile}
			  ${titleTypoStylesMobile}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper{
			  ${contentPaddingMobile}
		  }

		  .${blockId}.eb-toc-container .eb-toc-wrapper li{
			  ${contentTypoStylesMobile}
		  }

	  `;

    //
    const desktopAllStylesEditor = `
		  ${desktopAllStylesCommon}


		  .${blockId}.eb-toc-container .eb-toc-wrapper{
			  display:${visible ? "block" : "none"};
		  }
		  `;

    const tabAllStylesEditor = `
		  ${tabAllStylesCommon}
		  `;

    const mobileAllStylesEditor = `
		  ${mobileAllStylesCommon}
	  `;

    // all css styles for large screen width (desktop/laptop) in strings ⬇
    const desktopAllStyles = softMinifyCssStrings(`
		  ${desktopAllStylesCommon}
		  ${isSticky
            ? `
					.${blockId}.eb-toc-container.eb-toc-sticky-right.eb-toc-is-sticky {
						position:fixed;
						top: ${topSpace === 0 || topSpace ? topSpace : 25}%;
						z-index:999;
						left: auto;
						right: 0;
					}

					.${blockId}.eb-toc-container.eb-toc-sticky-left.eb-toc-is-sticky {
						position:fixed;
						top: ${topSpace === 0 || topSpace ? topSpace : 25}%;
						z-index:999;
						left: 0;
					}

				  .${blockId}.eb-toc-container.eb-toc-is-sticky .eb-toc-wrapper{
					  ${contentHeight ? `min-height:${contentHeight}px;` : ""}
				  }

				  .${blockId}.eb-toc-container.eb-toc-is-sticky button.eb-toc-button{
					  color:${titleColor};
					  background-color:${titleBg};
				  }

				  .${blockId}.eb-toc-container.eb-toc-is-sticky button.eb-toc-button.eb-toc-button-right {
					right: 0;
					left: auto;
					transform-origin: right top;
					transform: rotate(90deg) translate(100%, 0);
				  }
				  `
            : ""
        }


	  `);

    // all css styles for Tab in strings ⬇
    const tabAllStyles = softMinifyCssStrings(`
		  ${tabAllStylesCommon}


	  `);

    // all css styles for Mobile in strings ⬇
    const mobileAllStyles = softMinifyCssStrings(`
		  ${mobileAllStylesCommon}

	  `);

    //
    // styling codes End here
    //

    return (
        <>
            <StyleComponent
                attributes={attributes}
                setAttributes={setAttributes}
                desktopAllStyles={desktopAllStyles}
                tabAllStyles={tabAllStyles}
                mobileAllStyles={mobileAllStyles}
                editorDesktopStyles={desktopAllStylesEditor}
                editorTabStyles={tabAllStylesEditor}
                editorMobileStyles={mobileAllStylesEditor}
                blockName={name}
            />
        </>
    );
}
