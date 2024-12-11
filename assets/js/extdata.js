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
    fields: [ 'name', 'email', 'phone' ]
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




Ext.create('Ext.grid.Panel', {
    renderTo: Ext.getBody(),
    store: userStore,
    width: 400,
    height: 200,
    title: 'Application Users',
    columns: [
        {
            text: 'Name',
            width: 100,
            sortable: false,
            hideable: false,
            dataIndex: 'name'
        },
        {
            text: 'Email Address',
            width: 150,
            dataIndex: 'email'
        },
        {
            text: 'Phone Number',
            flex: 1,
            dataIndex: 'phone'
        }
    ]
});

 
});