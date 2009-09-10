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
