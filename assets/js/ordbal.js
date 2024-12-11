Ext.Loader.setConfig({enabled: true});
		
		Ext.Loader.setPath('Ext.ux', '../extjs-4.1.0/examples/ux/');			
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
			'Ext.layout.container.Column'
		]);


Ext.onReady(function(){
    Ext.QuickTips.init();

Ext.define('User', {
    extend: 'Ext.data.Model',
    fields: [ 'partnumber', 'partname','orderqty','reqdate',
	      'ponumber','posq','ordbal','supprest','model',
              'issdate','potype','statuspart'	
            ]
});


 var userStore = Ext.create('Ext.data.Store', {
    model: 'User',
    autoLoad: true,
    pageSize: 4,
    proxy: {
        type: 'ajax',
        url : '../json/jsonordbal.php',
        reader: {
            type: 'json',
            root: 'users',
            totalProperty: 'total'
                }
           }
});


var grd = new Ext.grid.Panel({

// Ext.create('Ext.grid.Panel', {
//    renderTo: Ext.getBody(),
    store: userStore,
    width: '100%',
    heigth: '100%',
    layout: 'fit',
     viewConfig: {
       forceFit: true
     },
    
    height: 300,
//    title: 'Order Balance',
    columns: [
        {
           text: 'Part Number',
            width: 100,
            sortable: false,
            hideable: false,
            dataIndex: 'partnumber'
        },
        {
            text: 'Part Name',
            width: 100,
            dataIndex: 'partname'
        },
        {
            text: 'Order QTY',
      //      flex: 1,
            width:100,
	    align: 'right',
            dataIndex: 'orderqty'
        },
	
	{
            text: 'Req date',
            width: 100,
            dataIndex: 'reqdate'
	},
        {
            text: 'PO Number',
            width: 100,
            dataIndex: 'ponumber'
       },
        {
            text: 'SQ',
            width: 50,
            dataIndex: 'posq'
       },
        {
            text: 'Order Balance',
            width: 100,
            dataIndex: 'ordbal'
       },
	{
            text: 'Supp Rest',
            width: 100,
            dataIndex: 'supprest'
       },
	{
            text: 'MODEL',
            width: 100,
            dataIndex: 'model'
       },
       {
            text: 'Issue Date',
            width: 100,
            dataIndex: 'issdate'
       }, 
       {
            text: 'PO Type',
            width: 100,
            dataIndex: 'potype'
       },

	{
            text: 'Part Status',
            width: 100,
            dataIndex: 'statuspart'
       },

]

});


var gridWindow = new Ext.Window({
    title: 'Order Balance',
     width:800,
     height:'100%',
    maximizable:true,
    items: [
        grd
    ]
});

// Instead of grid.render, use gridWindow.show();
gridWindow.show();

 Ext.EventManager.onWindowResize(function () {
        grid.setSize(undefined, undefined);
    });


});