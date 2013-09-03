//事件派发机制的实现
var EventDispatcher = {
    addEventListener: function(eventType, handler) {
        //事件的存储
        if (!this.eventMap) {
            this.eventMap = {};
        }

        //对每个事件，允许添加多个监听
        if (!this.eventMap[eventType]) {
            this.eventMap[eventType] = [];
        }

        //把回调函数放入事件的执行数组
        this.eventMap[eventType].push(handler);
    },

    removeEventListener: function(eventType, handler) {
        for (var i=0; i<this.eventMap[eventType].length; i++) {
            if (this.eventMap[eventType][i] === handler) {
                this.eventMap[eventType].splice(i, 1);
                break;
            }
        }
    },

    dispatchEvent: function(event) {
        var eventType = event.type;
        for (var i=0; i<this.eventMap[eventType].length; i++) {
            //把对当前事件添加的处理函数拿出来挨个执行
            this.eventMap[eventType][i](event);
        }
    }
};

//简单的对象属性复制，把源对象上的属性复制到自己身上，只复制一层
Object.prototype.extend = function(base) {
    for (var key in base) {
        if (base.hasOwnProperty(key)) {
            this[key] = base[key];
        }
    }
    return this;
};



//作为一个控件，它的容器必须传入
function DataGrid(element) {
    this.columns = [];
    this.rows = [];

    element.innerHTML = '<table class="table table-bordered table-striped"><thead><tr></tr></thead><tbody></tbody><table>';

    this.header = element.firstChild.tHead;
    this.tbody = element.firstChild.tBodies[0];

    this.selectedRow = null;
}

DataGrid.prototype = {
    loadColumns: function (columns) {
        if (this.header.rows.length > 0) {
            this.header.removeChild(this.header.rows[0]);
        }
        var tr = this.header.insertRow(0);

        for (var i = 0; i < columns.length; i++) {
            var th = tr.insertCell(i);
            th.innerHTML = columns[i].label;
        }
        this.columns = columns;
    },

    loadData: function (data) {
        for (var i = 0; i < data.length; i++) {
            this.insertRow(data[i]);
        }

        //跟外面说一声，数据加载好了
        var event = {
            type: "loadCompleted",
            target: this
        };
        this.dispatchEvent(event);
    },

    insertRow: function (data) {
        var row = new DataRow(data, this);
        this.tbody.appendChild(row.dom);

        this.rows.push(row);

        var that = this;
        row.addEventListener("selected", function (event) {
            that.select(event.row);
        });

        //已经成功添加了新行
        var event = {
            type: "rowInserted",
            newRow: row,
            target: this
        };
        this.dispatchEvent(event);
    },

    removeRow: function (row) {
        if (row === this.selectedRow) {
            this.selectedRow = null;
        }

        this.tbody.removeChild(row.dom);
        row.destroy();

        for (var i = 0; i < this.rows.length; i++) {
            if (this.rows[i] == row) {
                this.rows.splice(i, 1);
                break;
            }
        }

        //已经移除
        var event = {
            type: "rowRemoved",
            target: this
        };
        this.dispatchEvent(event);
    },

    select: function (row) {
        var event = {
            type: "changed",
            target: this,
            oldRow: this.selectedRow,
            newRow: row
        };

        if (this.selectedRow) {
            this.selectedRow.select(false);
        }

        if (row) {
            row.select(true);
        }

        this.selectedRow = row;

        this.dispatchEvent(event);
    }
}.extend(EventDispatcher);


function DataRow(data, grid) {
    this.data = data;
    this.grid = grid;

    this.create();
}

DataRow.prototype = {
    create: function () {
        var row = document.createElement("tr");
        for (var i = 0; i < this.grid.columns.length; i++) {
            var cell = document.createElement("td");
            cell.innerHTML = this.data[this.grid.columns[i].field] || "";
            row.appendChild(cell);
        }
        this.dom = row;

        var that = this;
        row.onclick = function (event) {
            //通知上级，我被点了
            var newEvent = {
                type: "selected",
                target: that,
                row: that
            };
            that.dispatchEvent(newEvent);
        }
    },

    destroy: function () {
        this.dom = null;
        this.data = null;
        this.grid = null;
    },

    select: function (flag) {
        if (flag) {
            this.dom.className = "info";
        }
        else {
            this.dom.className = "";
        }
    },

    set: function (key, value) {
        this.data[key] = value;

        for (var i = 0; i < this.grid.columns.length; i++) {
            if (this.grid.columns[i].field === key) {
                this.dom.childNodes[i].innerHTML = value;
                break;
            }
        }
    },

    get: function (key) {
        return this.data[key];
    },

    refresh: function (data) {
        this.data = data;

        for (var i = 0; i < this.grid.columns.length; i++) {
            this.dom.childNodes[i].innerHTML = data[this.grid.columns[i].field] || "";
        }
    }
}.extend(EventDispatcher);