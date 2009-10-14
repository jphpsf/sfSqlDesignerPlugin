/***** override default wwwsqldesigner.js behaviors *****/

// override save method to not prompt for schema name
SQL.IO.prototype.serversave = function(e) {
	var xml = this.owner.toXML();
	var bp = this.owner.getOption("xhrpath");
	var url = bp + "backend/"+this.dom.backend.value+"/?action=save";
	var h = {"Content-type":"application/xml"};
	this.owner.window.showThrobber();
	OZ.Request(url, this.saveresponse, {xml:true, method:"post", data:xml, headers:h});
}

// override load method to not prompt for schema name
SQL.IO.prototype.serverload = function(e) {
	var bp = this.owner.getOption("xhrpath");
	var url = bp + "backend/"+this.dom.backend.value+"/?action=load";
	this.owner.window.showThrobber();
	OZ.Request(url, this.loadresponse, {xml:true});
}

// override init of table object to add behaviors and table options
SQL.Table.prototype.init = function(owner, name, x, y, z) {
	this.owner = owner;
	this.rows = [];
	this.keys = [];
	this.zIndex = 0;

	this.flag = false;
	this.selected = false;
	SQL.Visual.prototype.init.apply(this);
	this.data.comment = "";
	this.data.actAsTimestampable = "";
	this.data.actActAsSoftDelete = "";
	this.data.actAsVersionable = "";
	this.data.actAsTaggable = "";
	this.data.behaviors = "";
	this.data.connection = "";
	this.data.tableType = "";
	this.data.collate = "";
	this.data.charset = "";
	this.data.className = "";
	this.data.tableName = "";

	this.dom.container.className = "table";
	this.setTitle(name);
	this.x = x || 0;
	this.y = y || 0;
	this.setZ(z);
}

// override table xml generation code to support behaviors and table options
SQL.Table.prototype.toXML = function() {
	var t = this.getTitle().replace(/"/g,"&quot;");
	var xml = "";
	xml += '<table x="'+this.x+'" y="'+this.y+'" name="'+t+'">\n';
	for (var i=0;i<this.rows.length;i++) {
		xml += this.rows[i].toXML();
	}
	for (var i=0;i<this.keys.length;i++) {
		xml += this.keys[i].toXML();
	}
	var c = this.getComment();
	if (c) {
		c = c.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<comment>"+c+"</comment>\n";
	}

	/* add 4 checkbox behaviors */
	var ats = this.getActAsTimestampable();
	if (ats==1) {
		xml += "<actAsTimestampable>1</actAsTimestampable>\n";
	}
	var asd = this.getActAsSoftDelete();
	if (asd==1) {
		xml += "<actAsSoftDelete>1</actAsSoftDelete>\n";
	}
	var avs = this.getActAsVersionable();
	if (avs==1) {
		xml += "<actAsVersionable>1</actAsVersionable>\n";
	}
	var atg = this.getActAsTaggable();
	if (atg==1) {
		xml += "<actAsTaggable>1</actAsTaggable>\n";
	}
	/* add behaviors textarea */
	var b = this.getBehaviors();
	if (b) {
		b = b.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<behaviors>"+b+"</behaviors>\n";
	}

	/* add connection */
	var conn = this.getConnection();
	if (conn) {
		conn = conn.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<connection>"+conn+"</connection>\n";
	}

	/* add type */
	var type = this.getTableType();
	if (type) {
		type = type.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<tableType>"+type+"</tableType>\n";
	}

	/* add collate */
	var col = this.getCollate();
	if (col) {
		col = col.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<collate>"+col+"</collate>\n";
	}

	/* add charset */
	var charset = this.getCharset();
	if (charset) {
		charset = charset.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<charset>"+charset+"</charset>\n";
	}

	/* add object class name */
	var className = this.getClassName();
	if (className) {
		className = className.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<className>"+className+"</className>\n";
	}

	/* add table name */
	var tableName = this.getTableName();
	if (tableName) {
		tableName = tableName.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<tableName>"+tableName+"</tableName>\n";
	}

	xml += "</table>\n";
	return xml;
}

// override table xml to html code in order to support behaviors and table options
SQL.Table.prototype.fromXML = function(node) {
	var name = node.getAttribute("name");
	this.setTitle(name);
	var x = parseInt(node.getAttribute("x")) || 0;
	var y = parseInt(node.getAttribute("y")) || 0;
	this.moveTo(x, y);
	var rows = node.getElementsByTagName("row");
	for (var i=0;i<rows.length;i++) {
		var row = rows[i];
		var r = this.addRow("");
		r.fromXML(row);
	}
	var keys = node.getElementsByTagName("key");
	for (var i=0;i<keys.length;i++) {
		var key = keys[i];
		var k = this.addKey();
		k.fromXML(key);
	}

	for (var i=0;i<node.childNodes.length;i++) {
		var ch = node.childNodes[i];

		if (ch.tagName && ch.tagName.toLowerCase() == "comment" && ch.firstChild) {
			this.setComment(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "actastimestampable" && ch.firstChild && ch.firstChild.nodeValue==1) {
			this.setActAsTimestampable(1);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "actassoftdelete" && ch.firstChild && ch.firstChild.nodeValue==1) {
			this.setActAsSoftDelete(1);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "actasversionable" && ch.firstChild && ch.firstChild.nodeValue==1) {
			this.setActAsVersionable(1);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "actastaggable" && ch.firstChild && ch.firstChild.nodeValue==1) {
			this.setActAsTaggable(1);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "behaviors" && ch.firstChild) {
			this.setBehaviors(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "connection" && ch.firstChild) {
			this.setConnection(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "tabletype" && ch.firstChild) {
			this.setTableType(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "collate" && ch.firstChild) {
			this.setCollate(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "charset" && ch.firstChild) {
			this.setCharset(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "classname" && ch.firstChild) {
			this.setClassName(ch.firstChild.nodeValue);
		}
		if (ch.tagName && ch.tagName.toLowerCase() == "tablename" && ch.firstChild) {
			this.setTableName(ch.firstChild.nodeValue);
		}
	}
}

// override TableManager to support behaviors and table options
SQL.TableManager.prototype.init = function(owner) {
	this.owner = owner;
	this.dom = {
		container:OZ.$("table"),
		name:OZ.$("tablename"),
		comment:OZ.$("tablecomment"),
		actAsTimestampable:OZ.$("tableacttimestampable"),
		actActAsSoftDelete:OZ.$("tableactsoftdelete"),
		actAsVersionable:OZ.$("tableactversionable"),
		actAsTaggable:OZ.$("tableacttaggable"),
		behaviors:OZ.$("tablebehaviors"),
		connection:OZ.$("tableconnection"),
		tableType:OZ.$("tabletype"),
		collate:OZ.$("tablecollate"),
		charset:OZ.$("tablecharset"),
		className:OZ.$("tableclassname"),
		tableName:OZ.$("tabletablename")
	};

	this.selected = null;
	this.adding = false;

	var ids = ["addtable","removetable","aligntables","cleartables","addrow","edittable","tablekeys"];
	for (var i=0;i<ids.length;i++) {
		var id = ids[i];
		var elm = OZ.$(id);
		this.dom[id] = elm;
		elm.value = _(id);
	}

	var ids = ["tablenamelabel","tablecommentlabel"];
	for (var i=0;i<ids.length;i++) {
		var id = ids[i];
		var elm = OZ.$(id);
		elm.innerHTML = _(id);
	}


	this.select(false);

	this.save = this.bind(this.save);

	OZ.Event.add("area", "click", this.bind(this.click));
	OZ.Event.add(this.dom.addtable, "click", this.bind(this.preAdd));
	OZ.Event.add(this.dom.removetable, "click", this.bind(this.remove));
	OZ.Event.add(this.dom.cleartables, "click", this.bind(this.clear));
	OZ.Event.add(this.dom.addrow, "click", this.bind(this.addRow));
	OZ.Event.add(this.dom.aligntables, "click", this.owner.bind(this.owner.alignTables));
	OZ.Event.add(this.dom.edittable, "click", this.bind(this.edit));
	OZ.Event.add(this.dom.tablekeys, "click", this.bind(this.keys));

	this.dom.container.parentNode.removeChild(this.dom.container);
}

SQL.TableManager.prototype.edit = function(e) {
	this.owner.window.open(_("edittable"), this.dom.container, this.save);

	var title = this.selected.getTitle();
	this.dom.name.value = title;
	try { /* throws in ie6 */
		this.dom.comment.value = this.selected.getComment();
		if (this.selected.getActAsTimestampable()==1) this.dom.actAsTimestampable.checked="checked";
		if (this.selected.getActAsSoftDelete()==1) this.dom.actActAsSoftDelete.checked="checked";
		if (this.selected.getActAsVersionable()==1) this.dom.actAsVersionable.checked="checked";
		if (this.selected.getActAsTaggable()==1) this.dom.actAsTaggable.checked="checked";
		this.dom.behaviors.value = this.selected.getBehaviors();
		this.dom.connection.value = this.selected.getConnection();
		this.dom.tableType.value = this.selected.getTableType();
		this.dom.collate.value = this.selected.getCollate();
		this.dom.charset.value = this.selected.getCharset();
		this.dom.className.value = this.selected.getClassName();
		this.dom.tableName.value = this.selected.getTableName();
	} catch(e) {}

	/* pre-select table name */
	this.dom.name.focus();
	if (OZ.ie) {
		try { /* throws in ie6 */
			this.dom.name.select();
		} catch(e) {}
	} else {
		this.dom.name.setSelectionRange(0, title.length);
	}
}

SQL.Table.prototype.setActAsTimestampable = function(actAs) {
	this.data.actAsTimestampable = actAs;
}

SQL.Table.prototype.getActAsTimestampable = function() {
	return this.data.actAsTimestampable;
}

SQL.Table.prototype.setActAsSoftDelete = function(actAs) {
	this.data.actAsSoftDelete = actAs;
}

SQL.Table.prototype.getActAsSoftDelete = function() {
	return this.data.actAsSoftDelete;
}

SQL.Table.prototype.setActAsVersionable = function(actAs) {
	this.data.actAsVersionable = actAs;
}

SQL.Table.prototype.getActAsVersionable = function() {
	return this.data.actAsVersionable;
}

SQL.Table.prototype.setActAsTaggable = function(actAs) {
	this.data.actAsTaggable = actAs;
}

SQL.Table.prototype.getActAsTaggable = function() {
	return this.data.actAsTaggable;
}

SQL.Table.prototype.setBehaviors = function(b){
	this.data.behaviors = b;
}

SQL.Table.prototype.getBehaviors = function() {
	return this.data.behaviors;
}

SQL.Table.prototype.setConnection = function(c){
	this.data.connection = c;
}

SQL.Table.prototype.getConnection = function() {
	return this.data.connection;
}

SQL.Table.prototype.setTableType = function(t){
	this.data.tableType = t;
}

SQL.Table.prototype.getTableType = function() {
	return this.data.tableType;
}

SQL.Table.prototype.setCollate = function(c){
	this.data.collate = c;
}

SQL.Table.prototype.getCollate = function() {
	return this.data.collate;
}

SQL.Table.prototype.setCharset = function(c){
	this.data.charset = c;
}

SQL.Table.prototype.getCharset = function() {
	return this.data.charset;
}

SQL.Table.prototype.setClassName = function(c){
	this.data.className = c;
}

SQL.Table.prototype.getClassName = function() {
	return this.data.className;
}

SQL.Table.prototype.setTableName = function(t){
	this.data.tableName = t;
}

SQL.Table.prototype.getTableName = function() {
	return this.data.tableName;
}

SQL.TableManager.prototype.save = function() {
	this.selected.setTitle(this.dom.name.value);
	this.selected.setComment(this.dom.comment.value);
	this.selected.setActAsTimestampable(this.dom.actAsTimestampable.value);
	this.selected.setActAsSoftDelete(this.dom.actActAsSoftDelete.value);
	this.selected.setActAsVersionable(this.dom.actAsVersionable.value);
	this.selected.setActAsTaggable(this.dom.actAsTaggable.value);
	this.selected.setBehaviors(this.dom.behaviors.value);
	this.selected.setConnection(this.dom.connection.value);
	this.selected.setTableType(this.dom.tableType.value);
	this.selected.setCollate(this.dom.collate.value);
	this.selected.setCharset(this.dom.charset.value);
	this.selected.setClassName(this.dom.className.value);
	this.selected.setTableName(this.dom.tableName.value);
}
