
/*
 * Editor client script for DB table products
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
	var editor = new $.fn.dataTable.Editor( {
		ajax: '/app/control/frontend/plugins/editable/php/table.products.php',
		table: '#products',
		fields: [
			{
				"label": "amoName:",
				"name": "amoname"
			},
			{
				"label": "amotags:",
				"name": "amotags"
			}
		]
	} );

	var table = $('#products').DataTable( {
		ajax: '/app/control/frontend/plugins/editable/php/table.products.php',
		columns: [
			{
				"data": "amoName"
			},
			{
				"data": "amoTags"
			},
			{
				"data": "URL"
			},
			{
				"data": "redirect"
			},
			{
				"data": "category"
			}
		],
		select: true,
		lengthChange: false
	} );

	new $.fn.dataTable.Buttons( table, [
		{ extend: "create", editor: editor },
		{ extend: "edit",   editor: editor },
		{ extend: "remove", editor: editor }
	] );

	table.buttons().container()
		.appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
} );

}(jQuery));


