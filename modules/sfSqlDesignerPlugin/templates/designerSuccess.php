<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	WWW SQL Designer, (C) 2005-2009 Ondrej Zara, ondras@zarovi.cz
	Version: 2.3.3
	See license.txt for licencing information.
-->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
	<title>WWW SQL Designer</title>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo stylesheet_path('../sfSqlDesignerPlugin/css/style'); ?>" media="all" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo stylesheet_path('../sfSqlDesignerPlugin/css/ie6'); ?>" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo stylesheet_path('../sfSqlDesignerPlugin/css/ie7'); ?>" /><![endif]-->
	<link rel="stylesheet" href="<?php echo stylesheet_path('../sfSqlDesignerPlugin/css/print'); ?>" type="text/css" media="print" />
	<script type="text/javascript" src="<?php echo javascript_path('../sfSqlDesignerPlugin/js/oz'); ?>"></script>
	<script type="text/javascript" src="<?php echo javascript_path('../sfSqlDesignerPlugin/js/config'); ?>"></script>
	<script type="text/javascript" src="<?php echo javascript_path('../sfSqlDesignerPlugin/js/wwwsqldesigner'); ?>"></script>
	<script type="text/javascript" src="<?php echo javascript_path('../sfSqlDesignerPlugin/js/sfsqldesigner'); ?>"></script>
</head>

<body>
	<div id="area"></div>
	<div id="bar">
		<div class="shadow-left"></div>
		<div class="shadow-corner"></div>
		<div class="shadow-bottom"></div>

		<div>WWW SQL Designer</div>

		<hr/>

		<input type="button" id="saveload" />

		<hr/>

		<input type="button" id="addtable" />
		<input type="button" id="edittable" />
		<input type="button" id="tablekeys" />
		<input type="button" id="removetable" />
		<input type="button" id="aligntables" />
		<input type="button" id="cleartables" />

		<hr/>

		<input type="button" id="addrow" />
		<input type="button" id="editrow" />
		<input type="button" id="uprow" class="small" /><input type="button" id="downrow" class="small"/>
		<input type="button" id="foreigncreate" />
		<input type="button" id="foreignconnect" />
		<input type="button" id="removerow" />

		<hr/>

		<input type="button" id="options" />
		<a href="http://code.google.com/p/wwwsqldesigner/w/list" target="_blank"><input type="button" id="docs" value="" /></a>
	</div>

	<div id="minimap"></div>

	<div id="background"></div>

	<div id="window">
		<div id="windowtitle"><img id="throbber" src="<?php echo javascript_path('../sfSqlDesignerPlugin/images/throbber.gif'); ?>" alt="" title=""/></div>
		<div id="windowcontent"></div>
		<input type="button" id="windowok" />
		<input type="button" id="windowcancel" />
	</div>

	<div id="opts">
		<table>
			<tbody>
				<tr>
					<td>
						* <label id="language" for="optionlocale"></label>
					</td>
					<td>
						<select id="optionlocale"></select>
					</td>
				</tr>
				<tr>
					<td>
						* <label id="db" for="optiondb"></label>
					</td>
					<td>
						<select id="optiondb"></select>
					</td>
				</tr>
				<tr>
					<td>
						<label id="snap" for="optionsnap"></label>
					</td>
					<td>
						<input type="text" size="4" id="optionsnap" />
						<span class="small" id="optionsnapnotice"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label id="pattern" for="optionpattern"></label>
					</td>
					<td>
						<input type="text" size="6" id="optionpattern" />
						<span class="small" id="optionpatternnotice"></span>
					</td>
				</tr>
				<tr>
					<td>
						<label id="hide" for="optionhide"></label>
					</td>
					<td>
						<input type="checkbox" id="optionhide" />
					</td>
				</tr>
				<tr>
					<td>
						* <label id="vector" for="optionvector"></label>
					</td>
					<td>
						<input type="checkbox" id="optionvector" />
					</td>
				</tr>
			</tbody>
		</table>

		<hr />

		* <span class="small" id="optionsnotice"></span>
	</div>

	<div id="io">
		<table>
			<tbody>
				<tr>
					<td>
						<fieldset>
							<legend id="client"></legend>
							<input type="button" id="clientsave" />
							<input type="button" id="clientload" />
							<hr/>
							<input type="button" id="clientsql" />
						</fieldset>
					</td>
					<td>
						<fieldset>
							<legend id="server"></legend>
							<label for="backend" id="backendlabel"></label> <select id="backend" style="display:none"></select>
							<hr/>
							<input type="button" id="serversave" />
							<input type="button" id="serverload" />
							<input type="button" id="serverlist" style="display:none"/>
							<input type="button" id="serverimport" />
						</fieldset>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<fieldset>
							<legend id="output"></legend>
							<textarea id="textarea"></textarea>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="keys">
		<fieldset>
			<legend id="keyslistlabel"></legend>
			<select id="keyslist"></select>
			<input type="button" id="keyadd" />
			<input type="button" id="keyremove" />
		</fieldset>
		<fieldset>
			<legend id="keyedit"></legend>
			<table>
				<tbody>
					<tr>
						<td>
							<label for="keytype" id="keytypelabel"></label>
							<select id="keytype"></select>
						</td>
						<td></td>
						<td>
							<label for="keyname" id="keynamelabel"></label>
							<input type="text" id="keyname" size="10" />
						</td>
					</tr>
					<tr>
						<td colspan="3"><hr/></td>
					</tr>
					<tr>
						<td>
							<label for="keyfields" id="keyfieldslabel"></label><br/>
							<select id="keyfields" size="5" multiple="multiple"></select>
						</td>
						<td>
							<input type="button" id="keyleft" value="&lt;&lt;" /><br/>
							<input type="button" id="keyright" value="&gt;&gt;" /><br/>
						</td>
						<td>
							<label for="keyavail" id="keyavaillabel"></label><br/>
							<select id="keyavail" size="5" multiple="multiple"></select>
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</div>

	<div id="table">
		<table>
			<tbody>
				<tr>
					<td>
						<label id="tablenamelabel" for="tablename"></label>
					</td>
					<td>
						<input id="tablename" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tablecommentlabel" for="tablecomment"></label>
					</td>
					<td>
						<textarea rows="5" cols="40" id="tablecomment"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Behaviors
					</td>
					<td>
						<ul style="list-style-type:none">
							<li>
								<input type="checkbox" id="tableacttimestampable" value="1" />
								<label id="tableacttimestampablelabel" for="tableacttimestampable">actAsTimestampable</label>
							</li>
							<li>
								<input type="checkbox" id="tableactsoftdelete" value="1" />
								<label id="tableactsoftdeletelabel" for="tableactsoftdelete">actAsSoftDelete</label>
							</li>
							<li>
								<input type="checkbox" id="tableactversionable" value="1" />
								<label id="tableactversionablelabel" for="tableactversionable">actAsVersionable</label>
							</li>
							<li>
								<input type="checkbox" id="tableacttaggable" value="1" />
								<label id="tableacttaggablelabel" for="tableacttaggable">actAsTaggable</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<label id="tablebehaviorslabel" for="tablebehaviors">Other behaviors</label>
					</td>
					<td>
						<textarea rows="5" cols="40" id="tablebehaviors"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label id="tableconnectionlabel" for="tableconnection">Connection</label>
					</td>
					<td>
						<input id="tableconnection" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tabletypelabel" for="tabletype">Type (MyISAM,innodb,...)</label>
					</td>
					<td>
						<input id="tabletype" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tablecollatelabel" for="tablecollate">Collate</label>
					</td>
					<td>
						<input id="tablecollate" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tablecharsetlabel" for="tablecharset">Charset</label>
					</td>
					<td>
						<input id="tablecharset" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tableclassnamelabel" for="tableclassname">className</label>
					</td>
					<td>
						<input id="tableclassname" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label id="tabletablenamelabel" for="tabletablename">tableName</label>
					</td>
					<td>
						<input id="tabletablename" type="text" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		(function(){
			var d = new SQL.Designer();
			OZ.Event.add(window,"load",function(){
				d.io.serverload();
			});
		})();
	</script>
</body>
</html>
