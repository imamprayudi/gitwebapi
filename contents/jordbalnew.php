<html>

<head>
	<title>Order Balance New</title>
	<!-- Additional content -->
	<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
	<script src="../assets/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="../ext/theme-crisp-all.css" />

	<!-- <link rel="stylesheet" type="text/css" href="../../extjs-4.2.2/resources/css/ext-all-gray.css" />  -->
	<!-- <script type="text/javascript" src="../../extjs-4.2.2/ext-all.js"></script> -->

	<?php
	session_start();
	if (isset($_SESSION['usr'])) {
		$myUserId = $_SESSION["usr"];
	} else {
		echo "session time out";
	?>
		<script>
			window.location.href = '../index.php';
		</script>
	<?php
	}
	?>
	<!-- <style type="text/css">
  .x-column-header-inner { 
		font-weight: bold;
		text-align: center;
		white-space: normal;
	}
	.x-grid-cell {
	padding: 2px;
	}
	.x-grid-row-over .x-grid-cell-inner {
	font-weight: bold;
	}
		.x-column-header-inner .x-column-header-text {
			white-space: normal;
		}
		.x-grid3-col .x-form-field{
		height:50px !important;
		}
	</style> -->

	<script type="text/javascript" src="../ext/ext-all.js"></script>
	<script type="text/javascript" src="../ext/theme-crisp.js"></script>
	<script type="text/javascript">
		Ext.Loader.setConfig({
			enabled: true
		});
		Ext.Loader.setPath('Ext.ux', '../ext/classic/src');
		Ext.Loader.setPath('Ext.ajax', '../ext/src');

		Ext.onReady(function() {
			Ext.QuickTips.init();

			//	All about function
			//	***
			//	function untuk fontsize grid
			function upsize(val) {
				return '<font size="2" style="font-family:sans-serif; white-space:normal;">' + val + '</font>';
			}
			//	function untuk numeric
			function convertToRupiah(angka) {
				var rupiah = '';
				var angkarev = angka.toString().split('').reverse().join('');
				for (var i = 0; i < angkarev.length; i++)
					if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
				return rupiah.split('', rupiah.length - 1).reverse().join('');
			}

			function numeric(val) {
				if (val > 0) {
					return '<font size="2" style="font-family:sans-serif; white-space:normal; color:green; float:right;">' + convertToRupiah(val) + '</font>';
				} else if (val <= 0) {
					return '<font size="2" style="font-family:sans-serif; white-space:normal; color:red; float:right;">' + convertToRupiah(val) + '</font>';
				} else {
					return '<font size="2" style="font-family:sans-serif; white-space:normal; color:gray; float:right;">' + val + '</font>';
				}
				return val;
			}
			//	function untuk combine kolom grid
			function statusread(val) {
				if (val > 0) {
					return '<font size="2" style="font-family:sans-serif; white-space:normal;">&reg;</font>';
				} else {
					return '<font size="2" style="font-family:sans-serif; white-space:normal;">&nbsp;</font>';
				}

				return '<font size="2" style="font-family:sans-serif; white-space:normal;">' + val + '</font>';
			}
			//	function required
			var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
			//	new date
			var date = new Date();
			//	----***----  //

			//	All about json data
			//	***
			var itemperpage = 100;
			//	json store
			Ext.define('ordbal', {
				extend: 'Ext.data.Model',
				fields: ['partnumber', 'partname', 'orderqty', 'reqdate', 'ponumber', 'posq', 'orderbalance',
					'supprest', 'model', 'issuedate', 'potype', 'statusread'
				]
			});
			var datastore = Ext.create('Ext.data.JsonStore', {
				model: 'ordbal',
				autoLoad: true,
				useDefaultXhrHeader: false,
				pageSize: itemperpage,
				proxy: {
					type: 'ajax',
					url: '../jsonedi51/json_ordbal.php',
					reader: {
						type: 'json',
						root: 'rows',
						totalProperty: 'totalcount'
					}
				}
			});

			Ext.define('cbxsupp', {
				extend: 'Ext.data.Model',
				fields: ['suppcode', 'suppname']
			});
			var dscbxsupp = Ext.create('Ext.data.JsonStore', {
				model: 'cbxsupp',
				autoLoad: true,
				proxy: {
					type: 'ajax',
					url: '../jsonedi51/json_cbxsupp.php',
					extraParams: {
						valuserid: '<?= $myUserId ?>'
					},
					reader: {
						type: 'json',
						root: 'rows'
					}
				}
			});
			//	----***----  //

			//	Panel
			//	***
			//	form search
			Ext.widget('form', {
				renderTo: 'formsearch',
				bodyPadding: 5,
				frame: false,
				border: false,
				bodyStyle: 'background:transparent;',
				width: '95%',
				fieldDefaults: {
					labelAlign: 'left',
					labelStyle: 'font-weight:bold',
					anchor: '100%'
				},
				items: [{
					xtype: 'fieldcontainer',
					fieldLabel: 'Search on ',
					labelWidth: 87,
					layout: 'hbox',
					items: [{
						xtype: 'datefield',
						id: 'valstdate',
						name: 'valstdate',
						fieldCls: 'biggertext',
						emptyText: 'Start Scan Date',
						format: 'd-M-Y',
						margins: '0 6 6 0',
						value: Ext.Date.format(new Date(date.getFullYear(), date.getMonth(), 1), 'd-M-Y'),
						height: 35,
						flex: 1,
						listeners: {
							select: function() {
								Ext.getCmp('valendate').enable();
							},
							change: function(f, new_val) {
								var valdate = Ext.getCmp('valstdate').getValue();
								if (valdate == null) {
									Ext.getCmp('valendate').setValue('');
									Ext.getCmp('valendate').disable();
								} else {
									Ext.getCmp('valendate').setValue('');
									Ext.getCmp('valendate').setMinValue(Ext.getCmp('valstdate').getValue());
								}
							}
						}
					}, {
						xtype: 'datefield',
						id: 'valendate',
						name: 'valendate',
						fieldCls: 'biggertext',
						emptyText: 'End Scan Date',
						format: 'd-M-Y',
						margins: '0 6 6 0',
						value: Ext.Date.format(new Date(), 'd-M-Y'),
						height: 35,
						flex: 1,
						listeners: {
							specialkey: function(field, e) {
								if (e.getKey() == 13) {
									datastore.proxy.setExtraParam('valstdate', Ext.Date.format(new Ext.getCmp('valstdate').getValue(), 'Ymd'));
									datastore.proxy.setExtraParam('valendate', Ext.Date.format(new Ext.getCmp('valendate').getValue(), 'Ymd'));
									datastore.proxy.setExtraParam('valsuppcode', Ext.getCmp('valsuppcode').getValue());
									datastore.loadPage(1);
								}
							}
						}
					}, {
						xtype: 'combo',
						id: 'valsupp',
						name: 'valsupp',
						fieldCls: 'biggertext',
						emptyText: 'Supplier',
						queryMode: 'query',
						displayField: 'suppcode',
						valueField: 'suppcode',
						margins: '0 6 6 0',
						height: 35,
						flex: 2,
						editable: true,
						store: dscbxsupp,
						listConfig: {
							getInnerTpl: function() {
								return '<div> {suppname} - {suppcode} </div>';
							}
						},
						listeners: {
							select: function(combo) {
								var value = combo.getValue();
								var valsuppcode = combo.findRecordByValue(value).get('suppcode');
								var valsuppname = combo.findRecordByValue(value).get('suppname');
								Ext.getCmp('valsupp').setValue(valsuppname.trim() + ' - ' + valsuppcode.trim());
								Ext.getCmp('valsuppcode').setValue(valsuppcode.trim());

								datastore.proxy.setExtraParam('valstdate', Ext.Date.format(new Ext.getCmp('valstdate').getValue(), 'Ymd'));
								datastore.proxy.setExtraParam('valendate', Ext.Date.format(new Ext.getCmp('valendate').getValue(), 'Ymd'));
								datastore.proxy.setExtraParam('valsuppcode', valsuppcode.trim());
								datastore.loadPage(1);
							}
						}
					}, {
						xtype: 'hiddenfield',
						id: 'valsuppcode',
						name: 'valsuppcode',
					}, {
						xtype: 'label',
						text: '  ',
						margins: '5 5 0 5'
					}]
				}]
			});


			//	grid
			var clock = Ext.create('Ext.toolbar.TextItem', {
				text: Ext.Date.format(new Date(), 'g:i:s A')
			});
			var griddata = Ext.create('Ext.grid.Panel', {
				renderTo: 'panelgrid',
				title: 'Data Order Balance',
				store: datastore,
				height: (window.innerHeight) - 300,
				autoWidth: '100%',
				columnLines: true,
				multiSelect: true,
				viewConfig: {
					stripeRows: true,
					enableTextSelection: true
				},
				columns: [{
						header: 'No.',
						xtype: 'rownumberer',
						width: 50,
						height: 40,
						sortable: false
					},
					{
						text: 'Part Number',
						dataIndex: 'partnumber',
						flex: 1,
						renderer: upsize
					},
					{
						text: 'Part Name',
						dataIndex: 'partname',
						flex: 1,
						renderer: upsize
					},
					{
						text: 'Order Quantity',
						dataIndex: 'orderqty',
						width: 75,
						renderer: numeric
					},
					{
						text: 'Required Date',
						dataIndex: 'reqdate',
						width: 95,
						renderer: upsize
					},
					{
						text: 'PO Number',
						dataIndex: 'ponumber',
						width: 80,
						renderer: upsize,
						align: 'center'
					},
					{
						text: 'SQ',
						dataIndex: 'posq',
						width: 40,
						renderer: upsize
					},
					{
						text: 'Order Balance',
						dataIndex: 'orderbalance',
						width: 75,
						renderer: numeric
					},
					{
						text: 'Supp Rest',
						dataIndex: 'supprest',
						width: 75,
						renderer: numeric
					},
					{
						text: 'Model',
						dataIndex: 'model',
						flex: 1,
						renderer: upsize
					},
					{
						text: 'Issue Date',
						dataIndex: 'issuedate',
						width: 95,
						renderer: upsize
					},
					{
						text: 'PO Type',
						dataIndex: 'potype',
						width: 95,
						renderer: upsize
					},
					{
						text: 'Read Status',
						dataIndex: 'statusread',
						width: 65,
						renderer: statusread,
						align: 'center'
					}
				],
				listeners: {
					render: {
						fn: function() {
							Ext.fly(clock.getEl().parent()).addCls('x-status-text-panel').createChild({
								cls: 'spacer'
							});

							Ext.TaskManager.start({
								run: function() {
									Ext.fly(clock.getEl()).update(Ext.Date.format(new Date(), 'g:i:s A'));
								},
								interval: 1000
							});
						},
						delay: 100
					}
				},
				tbar: [{
						xtype: 'button',
						id: 'btn_refresh',
						margins: '0 0 0 5', // top right bottom left
						text: 'Refresh',
						tooltip: 'Refresh',
						handler: function() {
							Ext.getCmp('valstdate').reset();
							Ext.getCmp('valendate').reset();
							Ext.getCmp('valsupp').reset();

							datastore.proxy.setExtraParam('valstdate', Ext.Date.format(new Date(date.getFullYear(), date.getMonth(), 1), 'Ymd'));
							datastore.proxy.setExtraParam('valendate', Ext.Date.format(new Date(), 'Ymd'));
							datastore.proxy.setExtraParam('valsuppcode', '');
							datastore.loadPage(1);
						}
					}, {
						xtype: 'button',
						id: 'btn_download',
						margins: '0 0 0 5', // top right bottom left
						text: 'Download',
						tooltip: 'Download',
						handler: function() {
							var valstdate = Ext.Date.format(new Ext.getCmp('valstdate').getValue(), 'Ymd');
							var valendate = Ext.Date.format(new Ext.getCmp('valendate').getValue(), 'Ymd');
							var valsuppcode = Ext.getCmp('valsuppcode').getValue();
							window.open('../jsonedi51/down_ordbal.php?valstdate=' + valstdate + '&valendate=' + valendate + '&valsuppcode=' + valsuppcode + '');
						}
					},
					'->',
					{
						xtype: 'label',
						text: Ext.Date.format(new Date(), 'l, d F Y'),
						margins: '20 5 0 0',
						style: 'font-size: 8pt'
					},
					'-',
					clock
				],
				bbar: Ext.create('Ext.PagingToolbar', {
					pageSize: itemperpage,
					store: datastore,
					displayInfo: true,
					plugins: Ext.create('Ext.ux.ProgressBarPager', {}),
					listeners: {
						afterrender: function(cmp) {
							cmp.getComponent("refresh").hide();
						}
					}
				})
			});
			//	----***----  //
		});
	</script>
</head>

<body bgcolor="#ffffff">

	<?php
	// include("jmenucss.php");
	include('../contents_v2/layouts/header.php');

	?>
	<main id="main" class="main">

		<div class="pagetitle">
			<h1>Order Balance New</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Orders</a></li>
					<li class="breadcrumb-item active">Order Balance New</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section">
			<div class="row">
				<?php

				echo '<br />';
				// echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
				// echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
				// echo '<br />';
				// echo 'ORDER BALANCE';
				// echo '<br /><br />';
				?>


				<div id="formsearch" class="card border-secondary"></div>
				<div id="panelgrid" class="card border-secondary"></div>


			</div>
		</section>

	</main><!-- End #main -->

	<?php include('../contents_v2/layouts/footer.php'); ?>

</body>

</html>