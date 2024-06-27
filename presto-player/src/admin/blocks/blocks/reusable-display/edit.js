/** @jsx jsx */
import { css, jsx } from "@emotion/core";
import {
  useBlockProps,
  useInnerBlocksProps,
  store as blockEditorStore,
  __experimentalUseBlockPreview as useBlockPreview,
} from "@wordpress/block-editor";
import { BlockControls, InspectorControls } from "@wordpress/block-editor";
import {
  Button,
  Placeholder,
  Spinner,
  Toolbar,
  PanelBody,
  BaseControl,
  Flex,
} from "@wordpress/components";
import { store as coreStore, useEntityBlockEditor } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import ProvidersPlaceholder from "../../shared/ProvidersPlaceholder/ProvidersPlaceholder";
import { Icon, symbolFilled } from "@wordpress/icons";

export default ({ attributes, context, clientId }) => {
  const { id: idAttribute } = attributes;
  const id = context["presto-player/playlist-media-id"] || idAttribute;
  const blockProps = useBlockProps();
  const [blocks, onInput, onChange] = useEntityBlockEditor(
    "postType",
    "pp_video_block",
    { id }
  );

  const mediaBlocks = (blocks || []).filter(
    (block) => block.name === "presto-player/reusable-edit"
  );

  const hasSrc = (mediaBlocks?.[0]?.innerBlocks || []).some(
    (block) => block.attributes.src
  );

  const blockPreviewProps = useBlockPreview({
    blocks: mediaBlocks,
  });

  const innerBlocksProps = useInnerBlocksProps(blockProps, {
    value: blocks,
    onInput,
    onChange,
    templateLock: "all",
  });

  const { media, canEdit, onNavigateToEntityRecord, isMissing, hasResolved } =
    useSelect(
      (select) => {
        const queryArgs = ["postType", "pp_video_block", id];
        const hasResolved = select(coreStore).hasFinishedResolution(
          "getEntityRecord",
          queryArgs
        );
        const media = select(coreStore).getEntityRecord(...queryArgs);
        const canEdit = select(coreStore).canUserEditEntityRecord(...queryArgs);
        const { getSettings } = select(blockEditorStore);
        return {
          media,
          canEdit,
          isMissing: hasResolved && !media && id,
          hasResolved,
          onNavigateToEntityRecord: getSettings().onNavigateToEntityRecord,
          isResolving: select(coreStore).isResolving(
            "getEntityRecord",
            queryArgs
          ),
        };
      },
      [id, clientId]
    );

  if (!hasResolved) {
    return (
      <div {...blockProps}>
        <Placeholder>
          <Spinner />
        </Placeholder>
      </div>
    );
  }

  if (!id && context["presto-player/playlist-media-id"] !== undefined) {
    return (
      <Placeholder
        css={css`
          &.components-placeholder {
            min-height: 350px;
          }
        `}
        withIllustration
      />
    );
  }

  if (isMissing) {
    return (
      <div {...blockProps}>
        {__(
          "The selected media item has been deleted or is unavailable.",
          "presto-player"
        )}
      </div>
    );
  }

  if (!blocks.length) {
    return <ProvidersPlaceholder clientId={clientId} />;
  }

  // we can edit the original if there is a block src,
  // the user can edit, and there is a src or provider_video_id.
  const editOriginal =
    !!hasSrc &&
    !!canEdit &&
    !!(media?.details?.src || media?.details?.provider_video_id);

  return (
    <>
      {editOriginal && (
        <>
          <BlockControls>
            <Toolbar>
              <Button
                icon="edit"
                onClick={() =>
                  onNavigateToEntityRecord({
                    postId: id,
                    postType: "pp_video_block",
                  })
                }
              >
                {__("Edit Original", "presto-player")}
              </Button>
            </Toolbar>
          </BlockControls>
          <InspectorControls>
            <PanelBody>
              <Flex align="center" justify="flex-start">
                <Icon icon={symbolFilled} />
                <h2 class="block-editor-block-card__title">
                  {__("Synced", "presto-player")}
                </h2>
              </Flex>

              <BaseControl
                help={__(
                  "This item is synced with the media hub and can be reused across your site.",
                  "presto-player"
                )}
                css={css`
                  margin-bottom: 10px !important;
                `}
              ></BaseControl>

              <Button
                icon="edit"
                onClick={() =>
                  onNavigateToEntityRecord({
                    postId: id,
                    postType: "pp_video_block",
                  })
                }
                variant="secondary"
              >
                {__("Edit Original", "presto-player")}
              </Button>
            </PanelBody>
          </InspectorControls>
        </>
      )}
      {editOriginal ? (
        <div {...blockProps}>
          <div {...blockPreviewProps} />
        </div>
      ) : (
        <div {...innerBlocksProps} />
      )}
    </>
  );
};
