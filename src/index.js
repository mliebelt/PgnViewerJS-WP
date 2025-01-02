const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { SelectControl, TextControl, TextareaControl } = wp.components;
const { useBlockProps } = wp.blockEditor;

// Register the block
registerBlockType("pgn-viewer/block-editor", {
  title: __("PGN Viewer Block Editor", "pgn-viewer"),
  icon: "chess",
  category: "widgets",
  attributes: {
    position: { type: "string", default: "" },
    pgn: { type: "string", default: "" },
    orientation: { type: "string", default: "white" },
    piecestyle: { type: "string", default: "merida-gradient" },
    theme: { type: "string", default: "zeit" },
    boardsize: { type: "string", default: "400px" },
    width: { type: "string", default: "500px" },
    movesHeight: { type: "string", default: "" },
  },
  edit: ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps({
      className: "pgnv-wrapper",
    });

    return (
      <div {...blockProps}>
        {/* Group 1: Full-width Rows */}
        <div className="row group-1">
          <TextControl
            label={__("FEN", "pgn-viewer")}
            value={attributes.position}
            onChange={(position) => setAttributes({ position })}
          />
          <TextareaControl
            label={__("PGN", "pgn-viewer")}
            value={attributes.pgn}
            onChange={(pgn) => setAttributes({ pgn })}
          />
        </div>

        {/* Group 3: Three equally spaced controls */}
        <div className="row group-3">
          <SelectControl
            label={__("Orientation", "pgn-viewer")}
            value={attributes.orientation}
            options={[
              { label: __("White", "pgn-viewer"), value: "white" },
              { label: __("Black", "pgn-viewer"), value: "black" },
            ]}
            onChange={(orientation) => setAttributes({ orientation })}
          />
          <SelectControl
            label={__("Piece Style", "pgn-viewer")}
            value={attributes.piecestyle}
            options={[
              { label: __("Merida", "pgn-viewer"), value: "merida-gradient" },
              {
                label: __("Goodcomp", "pgn-viewer"),
                value: "goodcomp-gradient",
              },
              { label: __("Alpha", "pgn-viewer"), value: "alpha" },
              { label: __("Leipzig", "pgn-viewer"), value: "leipzig" },
            ]}
            onChange={(piecestyle) => setAttributes({ piecestyle })}
          />
          <SelectControl
            label={__("Theme", "pgn-viewer")}
            value={attributes.theme}
            options={[
              { label: __("Zeit", "pgn-viewer"), value: "zeit" },
              { label: __("Dark", "pgn-viewer"), value: "dark" },
              { label: __("Light", "pgn-viewer"), value: "light" },
            ]}
            onChange={(theme) => setAttributes({ theme })}
          />
        </div>

        {/* Group 3: Board size, width, and moves height */}
        <div className="row group-3">
          <TextControl
            label={__("Board Size", "pgn-viewer")}
            value={attributes.boardsize}
            onChange={(boardsize) => setAttributes({ boardsize })}
          />
          <TextControl
            label={__("Width", "pgn-viewer")}
            value={attributes.width}
            onChange={(width) => setAttributes({ width })}
          />
          <TextControl
            label={__("Moves Height", "pgn-viewer")}
            value={attributes.movesHeight}
            onChange={(movesHeight) => setAttributes({ movesHeight })}
          />
        </div>
      </div>
    );
    console.log("exit edit block");
  },
  save: () => null, // Block is server-side rendered
});
