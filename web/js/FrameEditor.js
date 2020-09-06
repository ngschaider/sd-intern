class FrameEditor {
    canvas;

    numGridLines = 7;
    gridLines = [];

    xInputEl;
    yInputEl;
    rotInputEl;

    readonly;

    positions = [];
    submitUrl = "";

    constructor(id, framePositions, submitUrl, readonly) {
        this.submitUrl = submitUrl;
        this.readonly = readonly;

        if (!this.readonly) {
            $("#" + id + "-add-position").click(this.onNewPosition.bind(this));
            $("#" + id + "-plus-grid").click(this.onPlusGrid.bind(this));
            $("#" + id + "-minus-grid").click(this.onMinusGrid.bind(this));

            document.addEventListener("keypress", this.onKeypress.bind(this));
            document.getElementById(id + "-submit").addEventListener("click", this.onSubmit.bind(this));

            this.numberEl = document.getElementById(id + "-number");
            this.colorEl = document.getElementById(id + "-color");
            this.xInputEl = document.getElementById(id + "-position-x");
            this.yInputEl = document.getElementById(id + "-position-y");
            this.rotInputEl = document.getElementById(id + "-rotation");

            this.numberEl.addEventListener("change", this.onNumberChange.bind(this));
            this.colorEl.addEventListener("change", this.onColorChange.bind(this));
            this.xInputEl.addEventListener("change", this.onXInputChange.bind(this));
            this.yInputEl.addEventListener("change", this.onYInputChange.bind(this));
            this.rotInputEl.addEventListener("change", this.onRotInputChange.bind(this));
        }

        var canvasEl = document.getElementById(id);
        var info = canvasEl.parentElement.getBoundingClientRect();

        var width = info.width;
        var height = width;

        // create a wrapper around native canvas element (with id="c")
        this.canvas = new fabric.Canvas(id, {
            width: width,
            height: height,
            selection: false,
        });

        if(!this.readonly) {
            this.canvas.on('object:moving', this.onObjectMoving.bind(this));
            this.canvas.on('selection:created', this.onSelectionCreated.bind(this));
            this.canvas.on('selection:cleared', this.hideInputElements.bind(this));
            this.canvas.on('selection:updated', this.onSelectionUpdated.bind(this));
        }

        this.deserialize(framePositions);

        this.drawBorder();
        this.drawGrid();
    }

    onSubmit(e) {
        var data = this.serialize();

        $.post(this.submitUrl, {FramePosition: data}, function (data, status) {
            if (data.status === "success") {
                alert("Erfolgreich gespeichert!");
                for (var i = 0; i < data.newIds.length; i++) {
                    this.positions[i].id = data.newIds[i];
                }
            } else {
                alert("Speichern fehlgeschlagen");
                console.log(data);
            }
        }.bind(this));
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

    onNumberChange(e) {
        var object = this.canvas.getActiveObject();
        console.log(object);
        if (!object) {
            return;
        }

        object.item(1).set("text", e.target.value);
        this.canvas.renderAll();
    }

    onColorChange(e) {
        var object = this.canvas.getActiveObject();
        console.log(object);
        if (!object) {
            return;
        }

        object.item(0).set("fill", e.target.value);
        this.canvas.renderAll();
    }

    onXInputChange(e) {
        var object = this.canvas.getActiveObject();
        if (!object) {
            return;
        }
        object.left = e.target.value * this.canvas.getWidth();
        object.setCoords();
        this.canvas.requestRenderAll();
    }

    onYInputChange(e) {
        var object = this.canvas.getActiveObject();
        if (!object) {
            return;
        }
        object.top = e.target.value * this.canvas.getHeight();
        object.setCoords();
        this.canvas.requestRenderAll();
    }

    onRotInputChange(e) {
        var object = this.canvas.getActiveObject();
        if (!object) {
            return;
        }
        object.angle = e.target.value;
        object.setCoords();
        this.canvas.requestRenderAll();
    }

    onKeypress(event) {
        var spaceX = this.getGridSpaceX();
        var spaceY = this.getGridSpaceY();
        var object = this.canvas.getActiveObject();

        if (!object) {
            return;
        }

        if (["w", "a", "s", "d"].indexOf(event.key.toLowerCase()) !== -1) {
            // move
            if (event.key.toLowerCase() === "w") {
                object.top -= spaceY;
            } else if (event.key.toLowerCase() === "a") {
                object.left -= spaceX;
            } else if (event.key.toLowerCase() === "s") {
                object.top += spaceY;
            } else if (event.key.toLowerCase() === "d") {
                object.left += spaceX;
            }

            object.left = Math.max(0, object.left);
            object.left = Math.min(this.canvas.getWidth(), object.left);

            object.top = Math.max(0, object.top);
            object.top = Math.min(this.canvas.getHeight(), object.top);

            object.setCoords();
            this.updateElementsWithObjectValues(object);
            this.canvas.requestRenderAll();
        }

        if (["q", "e"].indexOf(event.key.toLowerCase()) !== -1) {
            // rotate
            if (event.key.toLowerCase() === "q") {
                object.angle -= 360 / 16;
            } else if (event.key.toLowerCase() === "e") {
                object.angle += 360 / 16;
            }

            object.setCoords();
            this.updateElementsWithObjectValues(object);
            this.canvas.requestRenderAll();
        }
    }

    onObjectMoving(options) {
        options.target.left = this.snapToGridX(options.target.left);
        options.target.top = this.snapToGridY(options.target.top);
        this.updateElementsWithObjectValues(options.target);
    }

    hideInputElements() {
        this.numberEl.classList.add("d-none");
        this.colorEl.classList.add("d-none");
        this.xInputEl.classList.add("d-none");
        this.yInputEl.classList.add("d-none");
        this.rotInputEl.classList.add("d-none");
    }

    onSelectionUpdated(options) {
        this.updateElementsWithObjectValues(this.canvas.getActiveObject());
    }

    onSelectionCreated(options) {
        this.showInputElements();
        this.updateElementsWithObjectValues(this.canvas.getActiveObject());
    }

    showInputElements() {
        if(this.readonly) return;
        this.numberEl.classList.remove("d-none");
        this.colorEl.classList.remove("d-none");
        this.xInputEl.classList.remove("d-none");
        this.yInputEl.classList.remove("d-none");
        this.rotInputEl.classList.remove("d-none");
    }

    updateElementsWithObjectValues(object) {
        if(this.readonly) return;

        this.xInputEl.value = object.left / this.canvas.getWidth();
        this.yInputEl.value = object.top / this.canvas.getHeight();

        this.rotInputEl.value = object.angle;

        this.numberEl.value = object.item(1).text;
        this.colorEl.value = object.item(0).fill;
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
        var position = new Position(this);
        this.positions.push(position);
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

    serialize() {
        var data = [];
        for (var i = 0; i < this.positions.length; i++) {
            data.push(this.positions[i].serialize());
        }
        return data;
    }

    deserialize(data) {
        for (var i = 0; i < data.length; i++) {
            var pos = new Position(this);
            pos.deserialize(data[i]);
            this.positions.push(pos);
        }
    }
}

class Position {

    editor;
    group;
    id = null;

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
            originX: "center",
            originY: "center",
            hasControls: false,
            selectable: !this.editor.readonly,
            hoverCursor: this.editor.readonly ? "initial" : "move",
        })

        editor.canvas.add(this.group);
        if(!this.editor.readonly) {
            editor.canvas.setActiveObject(this.group);
        }
    }

    serialize() {
        var data = {
            color: this.group.item(0).fill,
            number: this.group.item(1).text,
            x: this.group.left / this.editor.canvas.getWidth(),
            y: this.group.top / this.editor.canvas.getHeight(),
            rotation: this.group.angle,
        }
        if (this.id) {
            data.id = this.id;
        }

        return data;
    }

    deserialize(data) {
        this.id = data.id;
        this.group.item(0).fill = data.color;
        this.group.item(1).text = data.number.toString();
        this.group.left = data.x * this.editor.canvas.getWidth();
        this.group.top = data.y * this.editor.canvas.getHeight();
        this.group.angle = data.rotation;
        this.group.setCoords();
        this.editor.canvas.requestRenderAll();
    }

    destroy() {
        this.editor.remove(this.group);
    }

}