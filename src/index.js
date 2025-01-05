const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const {
  SelectControl,
  TextControl,
  TextareaControl,
  Panel,
  PanelBody,
  CheckboxControl,
} = wp.components;
const { useBlockProps } = wp.blockEditor;

// Register the block
registerBlockType("pgn-viewer/block-editor", {
  title: __("PGN Viewer Block Editor", "pgn-viewer"),
  icon: "chess",
  category: "widgets",
  attributes: {
    mode: { type: "string", default: "view" },
    layout: { type: "string", default: "top" },
    position: { type: "string", default: "" },
    pgn: { type: "string", default: "" },
    orientation: { type: "string", default: "white" },
    piecestyle: { type: "string", default: "merida" },
    theme: { type: "string", default: "zeit" },
    boardsize: { type: "string", default: "400px" },
    width: { type: "string", default: "500px" },
    movesHeight: { type: "string", default: "" },
    showCoords: { type: "boolean", default: true },
    coordsInner: { type: "boolean", default: true },
    coordsFactor: { type: "number", default: 1 },
    coordsFontSize: { type: "number", default: 14 },
    colorMarker: { type: "string", default: "" },
    locale: { type: "string", default: "en" },
    figurine: { type: "string", default: "" },
    notationLayout: { type: "string", default: "inline" },
  },
  edit: ({ attributes, setAttributes }) => {
    // console.log("Current attributes:", attributes);
    const blockProps = useBlockProps({
      className: "pgnv-wrapper",
    });

    const onChangeShowCoords = (value) => {
      console.log("Changing showCoords to:", value);
      setAttributes({ showCoords: value });
    };

    return (
      <div {...blockProps}>
        {/* Mode Selector */}
        <div className="row group-12">
          <SelectControl
            label={__("Mode", "pgn-viewer")}
            value={attributes.mode}
            options={[
              { label: __("View", "pgn-viewer"), value: "view" },
              { label: __("Edit", "pgn-viewer"), value: "edit" },
              { label: __("Print", "pgn-viewer"), value: "print" },
              { label: __("Board", "pgn-viewer"), value: "board" },
            ]}
            onChange={(mode) => setAttributes({ mode })}
          />
          <TextControl
            label={__("FEN", "pgn-viewer")}
            value={attributes.position}
            onChange={(position) => setAttributes({ position })}
          />
        </div>
        {/* Group 1: Full-width Rows */}
        <div className="row group-1">
          <TextareaControl
            label={__("PGN", "pgn-viewer")}
            value={attributes.pgn}
            onChange={(pgn) => setAttributes({ pgn })}
          />
        </div>

        {/* Group 3: Three equally spaced controls.
         resizable, colorMarker */}
        <div className="row group-3">
          <CheckboxControl
            label={__("Orientation", "pgn-viewer")}
            help={__("Check for white, uncheck for black", "pgn-viewer")}
            checked={attributes.orientation === "white"}
            onChange={(isChecked) =>
              setAttributes({ orientation: isChecked ? "white" : "black" })
            }
          />
          <SelectControl
            label={__("Piece Style", "pgn-viewer")}
            value={attributes.piecestyle}
            options={[
              { label: __("Merida", "pgn-viewer"), value: "merida" },
              { label: __("Wikipedia", "pgn-viewer"), value: "wikipedia" },
              { label: __("Alpha", "pgn-viewer"), value: "alpha" },
              { label: __("Leipzig", "pgn-viewer"), value: "leipzig" },
              { label: __("USCF", "pgn-viewer"), value: "uscf" },
              { label: __("Case", "pgn-viewer"), value: "case" },
              { label: __("Condal", "pgn-viewer"), value: "condal" },
              { label: __("Maya", "pgn-viewer"), value: "maya" },
              { label: __("Beyer", "pgn-viewer"), value: "beyer" },
            ]}
            onChange={(piecestyle) => setAttributes({ piecestyle })}
          />
          <SelectControl
            label={__("Theme", "pgn-viewer")}
            value={attributes.theme}
            options={[
              { label: __("Zeit", "pgn-viewer"), value: "zeit" },
              { label: __("Green", "pgn-viewer"), value: "green" },
              { label: __("Blue", "pgn-viewer"), value: "blue" },
              { label: __("Falken", "pgn-viewer"), value: "falken" },
              { label: __("Beyer", "pgn-viewer"), value: "beyer" },
              { label: __("Sportverlag", "pgn-viewer"), value: "sportverlag" },
              { label: __("Informator", "pgn-viewer"), value: "informator" },
              { label: __("Brown", "pgn-viewer"), value: "brown" },
            ]}
            onChange={(theme) => setAttributes({ theme })}
          />
        </div>

        {/* Group 12: Layout and Width */}
        <div className="row group-12">
          <SelectControl
            label={__("Layout", "pgn-viewer")}
            value={attributes.layout}
            options={[
              { label: __("Top", "pgn-viewer"), value: "top" },
              { label: __("Bottom", "pgn-viewer"), value: "bottom" },
              { label: __("Left", "pgn-viewer"), value: "left" },
              { label: __("Right", "pgn-viewer"), value: "right" },
            ]}
            onChange={(layout) => setAttributes({ layout })}
          />
          <TextControl
            label={__("Width", "pgn-viewer")}
            value={attributes.width}
            onChange={(width) => setAttributes({ width })}
          />
        </div>

        {/* Expandable Advanced Settings */}
        <Panel>
          <PanelBody
            title={__("Board Settings", "pgn-viewer")}
            initialOpen={false}
          >
            <div className="row group-2">
              <TextControl
                label={__("Board Size", "pgn-viewer")}
                value={attributes.boardsize}
                onChange={(boardsize) => setAttributes({ boardsize })}
              />
              <TextControl
                label={__("Moves Height", "pgn-viewer")}
                value={attributes.movesHeight}
                onChange={(movesHeight) => setAttributes({ movesHeight })}
              />
            </div>
            <div className="row group-2">
              <CheckboxControl
                label={__("Resizable", "pgn-viewer")}
                help={__("Allow the reader to resize the board", "pgn-viewer")}
                checked={attributes.resizable == true}
                onChange={(resizable) => setAttributes({ resizable })}
              />
              <SelectControl
                label={__("Color Marker", "pgn-viewer")}
                value={attributes.colorMarker}
                options={[
                  { label: __("None", "pgn-viewer"), value: "" },
                  { label: __("Any", "pgn-viewer"), value: "any" },
                  { label: __("Circle", "pgn-viewer"), value: "circle" },
                  {
                    label: __("Circle Small", "pgn-viewer"),
                    value: "circle-small",
                  },
                  {
                    label: __("Circle Big", "pgn-viewer"),
                    value: "circle-big",
                  },
                  {
                    label: __("Square Small", "pgn-viewer"),
                    value: "cm-small",
                  },
                  { label: __("Circle Big", "pgn-viewer"), value: "cm-big" },
                ]}
                onChange={(colorMarker) => setAttributes({ colorMarker })}
              />
            </div>
          </PanelBody>
        </Panel>

        {/* Expandable Advanced Settings */}
        <Panel>
          <PanelBody
            title={__("Coordinate Settings", "pgn-viewer")}
            initialOpen={false}
          >
            <div className="row group-2">
              <CheckboxControl
                label={__("Show Coordinates", "pgn-viewer")}
                checked={attributes.showCoords}
                onChange={onChangeShowCoords}
              />
              <CheckboxControl
                label={__("Coordinates Inner", "pgn-viewer")}
                checked={attributes.coordsInner}
                onChange={(isChecked) =>
                  setAttributes({ coordsInner: isChecked })
                }
              />
              <TextControl
                label={__("Coords Factor", "pgn-viewer")}
                type="number"
                value={attributes.coordsFactor}
                onChange={(value) =>
                  setAttributes({ coordsFactor: parseFloat(value) })
                }
                step="0.1" // This allows decimal inputs
              />
              <TextControl
                label={__("Coords Font Size", "pgn-viewer")}
                type="number"
                value={attributes.coordsFontSize}
                onChange={(value) =>
                  setAttributes({ coordsFontSize: parseInt(value) })
                }
              />
            </div>
          </PanelBody>
        </Panel>

        {/* moves width, moves height, header?, notation, timerTime, showResult, timeAnnotation */}
        <div className="row group-3">
          <SelectControl
            label={__("Locale", "pgn-viewer")}
            value={attributes.locale}
            options={[
              { label: __("EN", "pgn-viewer"), value: "en" },
              { label: __("DE", "pgn-viewer"), value: "de" },
              { label: __("FR", "pgn-viewer"), value: "fr" },
              { label: __("ES", "pgn-viewer"), value: "es" },
              { label: __("IT", "pgn-viewer"), value: "it" },
            ]}
            onChange={(locale) => setAttributes({ locale })}
          />
          <SelectControl
            label={__("Figurine", "pgn-viewer")}
            value={attributes.figurine}
            options={[
              { label: __("None", "pgn-viewer"), value: "" },
              { label: __("Alpha", "pgn-viewer"), value: "alpha" },
              { label: __("Merida", "pgn-viewer"), value: "merida" },
              { label: __("Berlin", "pgn-viewer"), value: "berlin" },
              { label: __("Noto", "pgn-viewer"), value: "noto" },
              { label: __("Cachess", "pgn-viewer"), value: "cachess" },
            ]}
            onChange={(figurine) => setAttributes({ figurine })}
          />
          <SelectControl
            label={__("Notation Layout", "pgn-viewer")}
            value={attributes.notationLayout}
            options={[
              { label: __("Inline", "pgn-viewer"), value: "inline" },
              { label: __("List", "pgn-viewer"), value: "list" },
            ]}
            onChange={(notationLayout) => setAttributes({ notationLayout })}
          />
        </div>
      </div>
    );
    console.log("exit edit block");
  },
  save: () => null, // Block is server-side rendered
});
