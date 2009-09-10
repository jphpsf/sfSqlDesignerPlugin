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
	this.data.behaviors = "";

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
	var b = this.getBehaviors();
	if (b) {
		b = b.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;");
		xml += "<behaviors>"+b+"</behaviors>\n";
	}
	xml += "</table>\n";
	return xml;
}

// override table xml to html code in order to support behaviors and table options
SQL.Table.prototype.fromXML = function(node) {
//console.log('test');
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
	console.info(ch);

	if (ch.tagName ) console.log(ch.tagName)
		if (ch.tagName && ch.tagName.toLowerCase() == "comment" && ch.firstChild) {
			this.setComment(ch.firstChild.nodeValue);
		}
		/*if (ch.tagName && ch.tagName.toLowerCase() == "actastimestampable" && ch.firstChild) {
			this.setActAsTimestampable(ch.firstChild.nodeValue);
		}*/
		if (ch.tagName && ch.tagName.toLowerCase() == "behaviors" && ch.firstChild) {
			this.setBehaviors(ch.firstChild.nodeValue);
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
		behaviors:OZ.$("tablebehaviors")
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
		this.dom.behaviors.value = this.selected.getBehaviors();
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

SQL.Table.prototype.setBehaviors = function(b){
	this.data.behaviors = b;
}

SQL.Table.prototype.getBehaviors = function() {
	return this.data.behaviors;
}

SQL.TableManager.prototype.save = function() {
	this.selected.setTitle(this.dom.name.value);
	this.selected.setComment(this.dom.comment.value);
	//this.selected.setActAsTimestampable(this.dom.actAsTimestampable.value);
	this.selected.setBehaviors(this.dom.behaviors.value);
}
