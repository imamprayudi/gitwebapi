<script>
			Ext.Loader.setConfig({enabled: true});
		
			Ext.Loader.setPath('Ext.ux', '../extjs-4.1.1/examples/ux/');
			Ext.require([
				'Ext.*',
				'Ext.tip.*',
				'Ext.tab.*',
				'Ext.Action',
				'Ext.form.*',
				'Ext.grid.*',
				'Ext.data.*',
				'Ext.util.*',
				'Ext.window.*',
				'Ext.window.MessageBox',
				'Ext.ux.statusbar.StatusBar',
				'Ext.layout.container.Border',
				'Ext.layout.container.Column',
				'Ext.selection.CheckboxModel'
			]);
			
		Ext.onReady(function(){
			Ext.QuickTips.init();
			
		//	All about function
		//	***
			//	function untuk fontsize grid
				function upsize(val) {
					return '<font size="2" style="font-family:sans-serif; white-space:normal;">' + val + '</font>';
				}
				function content(val) {
					return '<font size="2" style="font-family:sans-serif; white-space:normal;">' + Ext.String.ellipsis(val, 250, false) + '</font>';
				}
			//	end function untuk column bigsize
			
			//	function required
				var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
			//	end of function required
		//	----***----  //
			
		//	All about json data
			//	***
				//	json
					var itemperpage = 25;
					
					Ext.define('disp_data',{
						extend	: 'Ext.data.Model',
						fields	: [ 'fno', 'dept', 'year', 'term', 'filename', 'remark' ]
					});
					
					var data_store = Ext.create('Ext.data.Store',{
						model	: 'disp_data',
						autoLoad: true,
						pageSize: itemperpage,
						proxy	: {
							type	: 'ajax',
							url		: '',
							reader	: {
								type			: 'json',
								root			: 'rows',
								totalProperty	: 'totalCount'
							}
						}
					});
				//	end of json
			//	----***----  //
			
			
			//	Grid data
			//	***
				//	grid panel
					var clock = Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'g:i:s A')});
					
					var grid_data = Ext.create('Ext.grid.Panel', {
						title		: 'Data Training',
						id			: 'tr_data',
						renderTo	: 'section',
						store		: data_store,
						width		: '100%',
						height		: 500,
						x			: 0,
						y			: 0,
						columnLines	: true,
						multiSelect	: true,
						viewConfig	: {
							stripeRows			: true,
							enableTextSelection : true
						},
						//----------------------------COLUMN---------------------------//
						columns		: [
							{ header: 'NO.', 		xtype: 'rownumberer', 	width: 50, height: 40, sortable: false },
							{ header: 'File No', 	dataIndex: 'fno',		hidden: true },
							{ header: 'File Name', 	dataIndex: 'filename',	flex: 1, renderer: upsize, align:'center' },
							{ header: 'Department', dataIndex: 'dept',		width: 400, renderer: upsize, align:'center' },
							{ header: 'Periode', 	columns: [
								{ header: 'Year', 		dataIndex: 'year',		width: 100, align:'center' },
								{ header: 'Term', 		dataIndex: 'term',		flex: 1, renderer: upsize, align:'center' },
								]
							},
							{ header: 'Remark', 	dataIndex: 'remark',	flex: 1, renderer: upsize, hidden:true }
						],
						//	end columns
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
						tbar : [
							{
								text	: 'Actions',
								id		: 'btn_actions',
								iconCls	: 'actions',
								menu	: [
									{
										text	: 'Delete Data',
										iconCls	: 'delete',
										handler	: del
									}
								]
							},
							'->',
							{
								xtype		: 'label',
								text		: Ext.Date.format(new Date(), 'l, d F Y'),
								margins		: '15 5 0 5'
							}, 
							'-',
							clock
						],
						
						bbar		: Ext.create('Ext.PagingToolbar', {
							pageSize	: itemperpage,
							//store		: ds_displayefilling,
							displayInfo	: true,
							plugins		: Ext.create('Ext.ux.ProgressBarPager', {}),
							listeners	: {
								afterrender: function(cmp) {
									cmp.getComponent("refresh").hide();
								}
							}
						})
					});
				//	end of grid panel
			//	----***----  //
			
			//	form delete
				function del() {
					var rec = grid_data.getSelectionModel().getSelection();
					if (rec == 0) {
						
					}
					else {
						var del_fno		= rec[0].data.fno;
						var del_fname	= rec[0].data.filename;
							
						var win_del;
						
						if(!win_del) {
							var form_del = Ext.create('Ext.form.Panel',{
								layout			: {
									type			: 'vbox',
									align			: 'stretch'
								},
								border			: false,
								bodyPadding		: 20,
								bodyStyle		: { background :'rgba(179, 230, 255, 0.4)' },
								fieldDefaults	: {
									labelWidth		: 150,
									labelStyle		: 'font-weight:bold',
									msgTarget		: 'side'
								},
								defaults		: {
									anchor			: '100%'
								},
								items			: [
									{
										xtype		: 'label',
										text		: 'Are you sure to delete '+ del_fname +' data ??'
									},
									{
										xtype	: 'hiddenfield',
										name	: 'del_fno',
										value	: del_fno
									},{
										xtype	: 'hiddenfield',
										name	: 'del_fname',
										value	: del_fname
									},
									{
										xtype	: 'hiddenfield',
										name	: 'typeform',
										value	: 'delete'
									},
								],
								buttons			: [
									{
										text		: 'Delete',
										iconCls		: 'delete',
										handler		: function() {
											var form = this.up('form').getForm();
											var popwindow = this.up('window');
											if (form.isValid()) {
												form.submit({
													url		: 'resp/resp_drdoc.php',
													waitMsg	: 'sending data',
													
													success	: function(form, action) {
														Ext.Msg.alert('Status', 'Succesfully delete data');
														popwindow.close();
														data_store.loadPage(1);
													},
											
													failure	: function(form, action) {
														Ext.Msg.show({
															title		:'Failure - Delete Item',
															icon		: Ext.Msg.ERROR,
															msg			: action.result.msg,
															buttons		: Ext.Msg.OK
														});
													}
												});
											}
										}
									}
								]
							});
							win_del = Ext.widget('window',{
								title			: 'Delete Item',
								width			: 450,
								minWidth		: 450,
								height			: 120,
								minHeight		: 120,
								modal			: false,
								constrain		: true,
								layout			: 'fit',
								border			: false,
								bodyBorder		: false,
								animateTarget	: 'btn_actions',
								items			: form_del,
								listeners		:{
									activate:function(){
										//Ext.getCmp('btn_search').disable();
										//Ext.getCmp('btn_download').disable();
										Ext.getCmp('btn_actions').disable();
									},
									close:function(){
										//Ext.getCmp('btn_search').enable();
										//Ext.getCmp('btn_download').enable();
										Ext.getCmp('btn_actions').enable();
									}
								}
							});
						}
						win_del.show();
					}
				}
				//	end of form del
		});
		</script>