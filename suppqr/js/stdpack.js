<script>
	Ext.Loader.setConfig({enabled: true});
	Ext.Loader.setPath('Ext.ux', '../extjs-4.2.2/examples/ux/');
	
	Ext.onReady( function () {
		Ext.QuickTips.init();
		
		//	All about function
		//	***
			//	function untuk fontsize grid
				function upsize(val) {
					return '<font white-space:normal;">' + val + '</font>';
				}
			//	end function untuk fontsize grid
			
			//	function required
				var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
			//	end of function required
		//	----***----  //
		
		
		//	All about json data
		//	***
			//	json				
				Ext.define('stdpack', {
					extend	: 'Ext.data.Model',
					fields	: [ 'id_item', 'check_item' ]
				});
				var ds_item = Ext.create('Ext.data.Store', {
					model		: 'item',
					autoLoad	: true,
					fields		: [ 'id_item', 'check_item' ],
					proxy		: {
						type	: 'ajax',
						url		: 'json/json_item.php',
						reader	: {
							type			: 'json',
							root			: 'rows',
							totalProperty	: 'totalCount'
						}
					}
				});
				var datastore = ds_item;
			//	end of json
		//	----***----  //
	});
</script>