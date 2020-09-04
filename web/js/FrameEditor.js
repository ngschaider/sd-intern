class FrameEditor {
    canvas;

    numGridLines = 3;
    gridLines = [];

    canvasEl;

    constructor(id, framePositions) {
        $("#" + id + "-add-position").click(this.onNewPosition.bind(this));
        $("#" + id + "-plus-grid").click(this.onPlusGrid.bind(this));
        $("#" + id + "-minus-grid").click(this.onMinusGrid.bind(this));


        this.canvasEl = document.getElementById(id);

        document.addEventListener("keypress", this.onKeypress.bind(this));

        var info = this.canvasEl.parentElement.getBoundingClientRect();

        var width = info.width;
        var height = width;

        // create a wrapper around native canvas element (with id="c")
        this.canvas = new fabric.Canvas(id, {
            width: width,
            height: height,
            selection: false,
        });

        this.canvas.on('object:moving', this.onCanvasMoving.bind(this));

        this.drawBorder();
        this.drawGrid();
    }

    snapToGridX(x) {
        var spaceX = this.getGridSpaceX();
        var x = Math.round(x / spaceX) * spaceX;

        // clamp to viewport of canvas
        x = Math.max(0, x);
        x = Math.min(this.canvas.getWidth(), x);

        return x;
    }

    snapToGridY(y) {
        var spaceY = this.getGridSpaceY();
        var y = Math.round(y / spaceY) * spaceY;

        y = Math.max(0, y);
        y = Math.min(this.canvas.getHeight(), y);

        return y;
    }

    getCanvasActive() {
        return this.canvaseEl === document.activeElement;
    }

    onKeypress(event) {
        var spaceX = this.getGridSpaceX();
        var spaceY = this.getGridSpaceY();
        var objects = this.canvas.getActiveObjects();
        for (var i = 0; i < objects.length; i++) {
            var x = objects[i].left;
            var y = objects[i].top;

            if (event.key == "w") {
                y -= spaceY;
            } else if (event.key == "a") {
                x -= spaceX;
            } else if (event.key == "s") {
                y += spaceY;
            } else if (event.key == "d") {
                x += spaceX;
            }
            objects[i].set({
                left: this.snapToGridX(x),
                top: this.snapToGridY(y),
            })

            // we have to force redrawing manually because we are not in an FabricJs event
            this.canvas.requestRenderAll();
        }
    }

    onCanvasMoving(options) {
        options.target.left = this.snapToGridX(options.target.left);
        options.target.top = this.snapToGridY(options.target.top);
    }

    drawBorder() {
        this.drawLine(0, 0, this.canvas.getWidth(), 0);
        this.drawLine(this.canvas.getWidth() - 2, 0, this.canvas.getWidth() - 2, this.canvas.getHeight());
        this.drawLine(this.canvas.getWidth(), this.canvas.getHeight() - 2, 0, this.canvas.getHeight() - 2);
        this.drawLine(0, 0, 0, this.canvas.getHeight());
    }

    drawGrid() {
        for (var i = 0; i < this.gridLines.length; i++) {
            this.canvas.remove(this.gridLines[i]);
        }
        this.gridLines = [];

        var spaceX = this.getGridSpaceX();
        var spaceY = this.getGridSpaceY();
        for (var i = 1; i < this.numGridLines + 1; i++) {
            var lineX = this.drawLine(spaceX * i, 0, spaceX * i, this.canvas.getHeight());
            this.gridLines.push(lineX);

            var lineY = this.drawLine(0, spaceY * i, this.canvas.getWidth(), spaceY * i);
            this.gridLines.push(lineY);
        }
    }

    getGridSpaceX() {
        return this.canvas.getWidth() / (this.numGridLines + 1);
    }

    getGridSpaceY() {
        return this.canvas.getHeight() / (this.numGridLines + 1);
    }

    drawLine(x1, y1, x2, y2) {
        var line = new fabric.Line([x1, y1, x2, y2], {
            stroke: "black",
            selectable: false,
            hoverCursor: "initial",
        });

        this.canvas.add(line);
        line.sendToBack();
        return line;
    }

    onNewPosition() {
        new Position(this);
    }

    onMinusGrid() {
        if (this.numGridLines > 1) {
            this.numGridLines = ((this.numGridLines + 1) / 2) - 1;
            this.drawGrid();
        }
    }

    onPlusGrid() {
        if (this.numGridLines < 63) {
            this.numGridLines = ((this.numGridLines + 1) * 2) - 1;
            this.drawGrid();
        }
    }

    transformX(x) {
        return (x + 0.5) * this.canvas.getWidth();
    }

    transformY(y) {
        return (y + 0.5) * this.canvas.getHeight();
    }

    transformWidth(x) {
        return x / this.canvas.getWidth();
    }

    transformHeight(x) {
        return y / this.canvas.getHeight();
    }
}

class Position {

    editor;
    group;

    constructor(editor) {
        this.editor = editor;


        var triangle = new fabric.Triangle({
            left: 0,
            top: 0,
            width: 25,
            height: 35,
            fill: "cyan",
            stroke: "gray",
        });

        var number = new fabric.Text("1", {
            fontSize: 18,
            left: 12.5,
            top: 25,
            originX: "center",
            originY: "center",
        });

        this.group = new fabric.Group([triangle, number], {
            top: editor.transformY(0),
            left: editor.transformX(0),
            width: 50,
            height: 50,
            stroke: 'red',
            originX: "center",
            originY: "center",
            hasControls: false,
            //selectable: true,
        })

        editor.canvas.add(this.group);
    }

    destroy() {
        this.editor.remove(this.group);
    }

}