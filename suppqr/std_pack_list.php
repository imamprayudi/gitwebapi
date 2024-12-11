<?php
	session_start();
	$session_userid = $_SESSION['s_userid'];
	
	if(isset($_GET['suppcode']))
	{
		$supp = $_GET['suppcode'];
	}
	
	if ($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		// bukan dari posting
	}
	else
	{
		$supp = $_POST['suppcode'];
	}
	
	include('connection_odbc_mssql.php');
	$rs		 	= $db->Execute("select suppname from usersupp where suppcode = $supp");
	$suppname 	= $rs->fields[0];
	$rs->Close();
	$db->Close();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> JEIN - Barcode Receiving Online </title>
		<link rel="shortcut icon" href= "icons/receiving.ico"/>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
		<script type="text/javascript" src="../extjs-4.2.2/ext-all.js"></script>
		<link rel="stylesheet" type="text/css" href="../extjs-4.2.2/resources/css/ext-all-gray.css" />
		<style type="text/css">
			/* style rows on mouseover */
			.x-grid-row-over .x-grid-cell-inner {
				font-weight: bold;
			}
			/* shared styles for the ActionColumn icons */
			.x-action-col-cell img {
				cursor: pointer;
			}
			.x-grid-row-summary  .x-grid-cell-inner {
				font-weight: bold;
				font-size: 11px;
				padding-bottom: 4px;
			}
			.x-grid-row-summary {
				color:#333;
				background: #f1f2f4;
			}		
			.x-column-header-inner { 
				font-weight: bold;
				text-align: center;
				white-space: normal;
			}
			.x-column-header-inner .x-column-header-text {
				white-space: normal;
			}
			.x-grid-cell {
				padding: 2px;
			}
			
			/* icon */
			.refresh {
				 background-image:url(icons/refresh.gif) !important;
			}
			.update {
				 background-image:url(icons/update.png) !important;
			}
			.search {
				 background-image:url(icons/search.png) !important;
			}
			.reset {
				 background-image:url(icons/reset.png) !important;
			}
		</style>
		<script type="text/javascript">
			Ext.Loader.setPath('Ext.ux', '../extjs-4.2.2/examples/ux');

			Ext.require([
			  'Ext.ux.statusbar.StatusBar'
			]);
		
			Ext.onReady(function(){
				Ext.QuickTips.init();
				
				//	All about function
				//	***
					//	function untuk fontsize grid
						function upsize(val) {
							return '<font size="2" style="font-family:sans-serif; white-space:normal;">' + val + '</font>';
						}
					//	end function untuk fontsize grid
					
						
					//	function untuk field supplier
						function supplier(val) {
							return '<font size="2" style="font-family:sans-serif; white-space:normal;"><?=$supp?> - <?=$suppname?></font>';
						}
					//	end function untuk field supplier
				//	----***----  //
				
				
				//	All about json data
				//	***
					//	json
						Ext.define('stdpacksupp', {
							extend	: 'Ext.data.Model',
							fields	: [ 'partnumber', 'partname', 'stdpack_supp', 'replikasi' ]
						});
						var ds_stdpacksupp = Ext.create('Ext.data.Store', {
							model		: 'stdpacksupp',
							fields		: [ 'partnumber', 'partname', 'stdpack_supp', 'replikasi' ],
							proxy		: {
								type	: 'ajax',
								url		: 'json/json_stdpacksupp.php',
								reader	: {
									type			: 'json',
									root			: 'rows',
									totalProperty	: 'totalCount'
								}
							},
							listeners	: {
								load: function(store, records){
									var totalcount = store.getCount();
									Ext.getCmp('labelcount').setText('Displaying '+totalcount+' records');
								}
							}
						});
						var datastore = ds_stdpacksupp;
						datastore.proxy.setExtraParam('supp', <?=$supp?> );
						datastore.loadPage(1);
					//	end of json
				//	----***----  //
				
				
				//	Grid data
				//	***
					//	grid panel
						var clock = Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'g:i:s A')});
						var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
							clicksToEdit: 1
						});
				
						var grd_stdpacksupp = Ext.create('Ext.grid.Panel', {
							stateId		: 'grd_stdpacksupp',
							renderTo	: 'grd_stdpacksupp',
							title		: 'Setup Standard Packing',
							store		: datastore,
							width		: '100%',
							height		: 400,
							x 			: 0, 
							y 			: 0,
							border		: true,
							columnLines	: true,
							multiSelect	: true,
							viewConfig	: {
								stripeRows			: true,
								enableTextSelection	: true
							},
							plugins: [cellEditing],
							selModel: {
								selType: 'cellmodel'
							},
							columns		: [
								{ header: 'NO.', xtype: 'rownumberer', width: 50, height: 40, sortable: false },
								{ header: 'Supplier name', 	dataIndex: '', 				flex: 1, renderer: supplier },
								{ header: 'Part Number', 	dataIndex: 'partnumber', 	flex: 1, renderer: upsize },
								{ header: 'Part Name', 		dataIndex: 'partname', 		flex: 1, renderer: upsize },
								{ header: 'Standard QTY', 	dataIndex: 'stdpack_supp', 	flex: 1, renderer: upsize,
									field: {
										xtype		: 'numberfield',
										name		: 'stdpack_supp',
										minValue	: 0,
										maxValue	: 99999999999,
										allowBlank	: false
									}
								},
								{ header: 'ID', 			dataIndex: 'replikasi', 	flex: 1, renderer: upsize, hidden: true },
						
							],
							listeners: {
								render: {
									fn: function(){
										Ext.fly(clock.getEl().parent()).addCls('x-status-text-panel').createChild({cls:'spacer'});

									 Ext.TaskManager.start({
										 run: function(){
											 Ext.fly(clock.getEl()).update(Ext.Date.format(new Date(), 'g:i:s A'));
										 },
										 interval: 1000
									 });
									},
									delay: 100
								}
							},
							tbar		: [
								{
									xtype	: 'button',
									id		: 'btn_refresh',
									iconCls	: 'refresh',
									text 	: 'Refresh',
									tooltip	: 'Refresh',
									handler : function (){
										datastore.proxy.setExtraParam('supp', <?=$supp?> );
										datastore.proxy.setExtraParam('partnumber', '' );
										datastore.loadPage(1);
									}
								}, {
									xtype	: 'button',
									id		: 'btn_search',
									iconCls	: 'search',
									text	: 'Search',
									tooltip	: 'Search',
									handler	: fnc_search
								}, 
								'->',
								{
									xtype	: 'button',
									id		: 'btn_update',
									iconCls	: 'update',
									text	: 'Update Data',
									handler	: function() {
										Ext.Msg.confirm('Confirm', 'Are you sure want to update data ?', function(btn){
											if (btn == 'yes'){
												var record = grd_stdpacksupp.store.getUpdatedRecords();
												
												for (var i=0; i < record.length; i++) {
												//	alert(record[i].data.replikasi+' ## '+record[i].data.stdpack_supp);
												
													Ext.Ajax.request({
														url		: 'resp/resp_stdsupp.php',
														method	: 'POST',
														params	: 'replikasi='+record[i].data.replikasi+'&stdpack_supp='+record[i].data.stdpack_supp,
														success	: function(obj) {
															var resp = obj.responseText;
															if (resp != 0) {
																datastore.loadPage(1);
																
															} else {
																Ext.Msg.show({
																	title		:'Edit Data',
																	icon		: Ext.Msg.ERROR,
																	msg			: resp,
																	buttons		: Ext.Msg.OK
																});
															}
														}
													});
												}
											}
											else{
												datastore.proxy.setExtraParam('supp', <?=$supp?> );
												datastore.proxy.setExtraParam('partnumber', '' );
												datastore.loadPage(1);
											}
										});
									}
								},
								'-',
								{
									xtype		: 'label',
									text		: Ext.Date.format(new Date(), 'l, d F Y'),
									margins		: '15 5 0 5'
								}, 
								clock
							],
							
							bbar: Ext.create('Ext.ux.StatusBar', {
								items:[
									{
										xtype		: 'label',
										id			: 'labelcount',
										name		: 'labelcount',
										text		: 'Displaying ...',
										margins		: '15 5 0 5',
										style		: 'font-weight: bold; color: #808080;'
									}
								]
							})
						});
					//	end of grid panel
				//	----***----  //
				
				
				//	All about form
				//	***
					//	form search
						function fnc_search() {
							var win_search;
							var date = new Date();
							
							if (!win_search) {
								var frm_search = Ext.widget('form', {
									layout			: {
										type	: 'vbox',
										align	: 'stretch'
									},
									border			: false,
									bodyPadding		: 10,

									fieldDefaults	: {
										labelWidth	: 150,
										labelStyle	: 'font-weight:bold',
										msgTarget	: 'side'
									},
									defaults		: {
										margins	: '0 0 10 0'
									},
									items			: [
										{
											xtype				: 'textfield',
											id					: 'partnumber',
											name				: 'partnumber',
											fieldLabel			: 'Part Number',
											listeners 			: {
												afterrender	: function(field) {
													field.focus(false, 1000);
												},
												specialkey : function(field, e) {
													if (e.getKey() == 13) {
														datastore.proxy.setExtraParam('partnumber', Ext.getCmp('partnumber').getValue() );
														datastore.loadPage(1);
													}
												}
											}
										}
									],
									buttons			: [
										{
											text		: 'Reset',
											iconCls		: 'reset',
											handler		: function() { 
												this.up('form').getForm().reset();
												datastore.proxy.setExtraParam('supp', <?=$supp?> );
												datastore.proxy.setExtraParam('partnumber', '' );
												datastore.loadPage(1);
												
												win_search.close();
											}
										}, {
											text		: 'Search',
											iconCls		: 'search',
											handler		: function() {										
												datastore.proxy.setExtraParam('supp', <?=$supp?> );
												datastore.proxy.setExtraParam('partnumber', Ext.getCmp('partnumber').getValue() );
												datastore.loadPage(1);
											}
										}
									]
								});
								win_search = Ext.widget('window', {
									title			: 'Search by field',
									width			: 400,
									minWidth		: 400,
									autoheight		: true,
									modal			: false,
									constrain		: true,
									layout			: 'fit',
									animateTarget	: 'btn_search',
									items			: frm_search,
									listeners		:{
										activate:function(){
											Ext.getCmp('btn_search').disable();
											Ext.getCmp('btn_update').disable();
										},
										close:function(){
											Ext.getCmp('btn_search').enable();
											Ext.getCmp('btn_update').enable();
										}
									}
								});
							}
							win_search.show();
						}
					//	end of form search
				//	----***----  //
			});
		</script>
	</head>
	
	<body>
		<div id="wrapper">
			<div id="header"> 
				<table height="100px" width="100%">
					<tr> 
						<td valign="bottom"> <img class="logo" src="img/jvc-logo.png"> </td>
						<td valign="bottom">
							<div class="description">
								<p> PT. JVCKENWOOD ELECTRONICS INDONESIA </p>
								<p> JL.SURYA LESTARI KAV.I-16B </p>
								<p> KOTA INDUSTRI SURYA CIPTA, </p>
								<p> TELUK JAMBE KARAWANG, </p>
								<p> 41361 - INDONESIA. TELP : (0267)440520 </p>
							</div>
						</td>
					</tr>
				</table> 
			</div>
			
			<div id="nav">
				<div class="menu">
					<?php include "1menu.php"; ?>
				</div>
			</div>
			
			<div id="section">
				<div id="grd_stdpacksupp"></div>
			</div>
		</div>		
	</body>
</html>