/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";
import { select } from "@wordpress/data";

/**
 * Internal depencencies
 */
import classnames from "classnames";

import Inspector from "./inspector";

import Style from "./style";

const {
    softMinifyCssStrings,
    generateTypographyStyles,
    generateDimensionsControlStyles,
    generateBorderShadowStyles,
    generateResponsiveRangeStyles,
    generateBackgroundControlStyles,
    // mimmikCssForPreviewBtnClick,
    duplicateBlockIdFix,
    DynamicInputValueHandler
} = window.EBControls;

export default function Edit(props) {
    const { attributes, setAttributes, className, clientId, isSelected, name } = props;
    const {
        blockId,
        blockMeta,
        // responsive control attribute ⬇
        resOption,
        preset,
        contentPosition,
        buttonTextOne,
        buttonTextTwo,
        textOneColor,
        hoverTextOneColor,
        textTwoColor,
        hoverTextTwoColor,
        innerButtonText,
        innerButtonColor,
        innerButtonTextColor,
        innerButtonIcon,
        showConnector,
        connectorType,
        buttonTextAlign,
        classHook,
        buttonsWidthType,
    } = attributes;

    // this useEffect is for creating a unique id for each block's unique className by a random unique number
    useEffect(() => {
        const BLOCK_PREFIX = "eb-button-group";
        duplicateBlockIdFix({
            BLOCK_PREFIX,
            blockId,
            setAttributes,
            select,
            clientId,
        });
    }, []);

    const blockProps = useBlockProps({
        className: classnames(className, `eb-guten-block-main-parent-wrapper`),
    });

    return (
        <>
            {isSelected && <Inspector {...props} />}
            <div {...blockProps}>
                <Style {...props} />

                <div className={`eb-parent-wrapper eb-parent-${blockId} ${classHook}`}>
                    <div
                        className={`eb-button-group-wrapper ${blockId} ${preset}`}
                        data-id={blockId}
                    >
                        {/* Button One */}
                        <a
                            className={"eb-button-parent eb-button-one"}
                            // style={buttonStyleOne}
                            onMouseEnter={() => setAttributes({ isHoverOne: true })}
                            onMouseLeave={() => setAttributes({ isHoverOne: false })}
                        >
                            <DynamicInputValueHandler
                                // style={textStylesOne}
                                className={"eb-button-text eb-button-one-text"}
                                placeholder="Add Text.."
                                value={buttonTextOne}
                                onChange={(newText) =>
                                    setAttributes({ buttonTextOne: newText })
                                }
                                allowedFormats={[
                                    "core/bold",
                                    "core/italic",
                                    "core/link",
                                    "core/strikethrough",
                                    "core/underline",
                                    "core/text-color",
                                ]}
                            />
                        </a>

                        {/* Connector */}

                        {showConnector && (
                            <div
                                className="eb-button-group__midldeInner"
                            // style={buttonMiddleInnerStyles}
                            >
                                {connectorType === "icon" && (
                                    <span>
                                        <i
                                            className={`${innerButtonIcon
                                                    ? innerButtonIcon
                                                    : "fas fa-arrows-alt-h"
                                                }`}
                                        ></i>
                                    </span>
                                )}

                                {connectorType === "text" && <span>{innerButtonText}</span>}
                            </div>
                        )}

                        {/* Button Two */}
                        <a
                            className={"eb-button-parent eb-button-two"}
                            // style={buttonStyleTwo}
                            onMouseEnter={() => setAttributes({ isHoverTwo: true })}
                            onMouseLeave={() => setAttributes({ isHoverTwo: false })}
                        >
                            <DynamicInputValueHandler
                                // style={textStylesTwo}
                                className={"eb-button-text eb-button-two-text"}
                                placeholder="Add Text.."
                                value={buttonTextTwo}
                                onChange={(newText) =>
                                    setAttributes({ buttonTextTwo: newText })
                                }
                                allowedFormats={[
                                    "core/bold",
                                    "core/italic",
                                    "core/link",
                                    "core/strikethrough",
                                    "core/underline",
                                    "core/text-color",
                                ]}
                            />
                        </a>
                    </div>
                </div>
            </div>
        </>
    );
}
