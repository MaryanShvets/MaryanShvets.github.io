<?
	
	// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	// $api = new API();
	$api->connect();

	// $product = $api->query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' ORDER BY id DESC ");
	$product = mysql_query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' ORDER BY id ASC ") or die(mysql_error());

?>

<html>
<head>
	<title>Отчеты</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.query-builder/2.4.1/js/query-builder.standalone.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.query-builder/2.4.1/css/query-builder.default.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="/app/control/frontend/css/boot.css"> -->

</head>	
<body class="page-report">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Отчеты</h1>

		<div id="builder"></div>

    <div class="btn-group">
      <button class="btn btn-danger reset">Обновить</button>
      <!-- <button class="btn btn-warning set-filters" data-toggle="tooltip" title="Adds a filter 'New filter' and removes 'Coordinates', 'State', 'BSON'" data-container="body" data-placement="bottom">Set filters</button> -->
    </div>

    <!-- <div class="btn-group">
      <button class="btn btn-default" disabled>Set:</button>
      <button class="btn btn-success set">From JSON</button>
      <button class="btn btn-success set-mongo">From MongoDB</button>
      <button class="btn btn-success set-sql">From SQL</button>
    </div> -->

    <div class="btn-group">
      <!-- button class="btn btn-default" disabled>Get:</button>
      <button class="btn btn-primary parse-json">JSON</button> -->
      <button class="btn btn-primary parse-sql" data-stmt="false">Показать</button>
      <!-- <button class="btn btn-primary parse-sql" data-stmt="question_mark">SQL statement</button>
      <button class="btn btn-primary parse-mongo">MongoDB</button> -->
    </div>

    <div id="result" class="hide">
      <h3>Output</h3>
      <pre></pre>
    </div>



		<!-- <div id="submit" class="mb-60 btn green">Отправить</div> -->

	</div>

	

	<div id="loading">
		<div class="cssload-container">
			<div class="cssload-whirlpool"></div>
		</div>

		<p>Сохраняем изменения</p>
	</div>

	<script type="text/javascript">

		var rules_basic = {
		  // condition: 'AND',
		  // rules: [{
		  //   id: 'price',
		  //   operator: 'less',
		  //   value: 10.25
		  // }, {
		  //   condition: 'OR',
		  //   rules: [{
		  //     id: 'category',
		  //     operator: 'equal',
		  //     value: 2
		  //   }, {
		  //     id: 'category',
		  //     operator: 'equal',
		  //     value: 1
		  //   }]
		  // }]
		};

		$('#builder').queryBuilder({
		  
			filters: [
				{
					id: 'utmsourse',
					label: 'Источник',
					type: 'string',
					optgroup: 'Регистрации',
					operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null']
				},
				{
					id: 'utmcampaigh',
					label: 'Кампания',
					type: 'string',
					optgroup: 'Регистрации',
					operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null']

				},
				{
					id: 'product',
					label: 'Продукт',
					type: 'string',
				    input: 'select',
				    optgroup: 'Регистрации',
					values: {

					<?
						while ($row = mysql_fetch_array($product)) {
							echo " '".$row['id']."' : '".$row['amoName']."',";
							// echo 'ok';
						}
					?>

				    },
					operators: ['equal', 'not_equal', 'in', 'not_in']

				},
				{
					id: 'pay_system',
					label: 'Система оплаты',
					type: 'string',
				    input: 'select',
				    optgroup: 'Финансы',
					values: {
						'fondy':'Фонди',
						'walletone':'Walletone'

				    },
					operators: ['equal', 'not_equal', 'in', 'not_in']

				},
				{
					id: 'status',
					label: 'Статус платежа',
					type: 'string',
				    input: 'select',
				    optgroup: 'Финансы',
					values: {
						'new':'Новый',
						'success':'Успешный'

				    },
					operators: ['equal', 'not_equal', 'in', 'not_in']

				},
				{
					id: 'pay_currenct',
					label: 'Валюта',
					type: 'string',
				    input: 'select',
				    optgroup: 'Финансы',
					values: {
						'uah':'Гривна',
						'rub':'Рубли',
						'usd':'Доллары'

				    },
					operators: ['equal', 'not_equal', 'in', 'not_in']
				},

			],

		  // }],filters: [{
		  //   id: 'name',
		  //   label: 'Name',
		  //   type: 'string'
		  // }, {
		  //   id: 'category',
		  //   label: 'Category',
		  //   type: 'integer',
		  //   input: 'select',
		  //   values: {
		  //     1: 'Books',
		  //     2: 'Movies',
		  //     3: 'Music',
		  //     4: 'Tools',
		  //     5: 'Goodies',
		  //     6: 'Clothes'
		  //   },
		  //   operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null']
		  // }, {
		  //   id: 'in_stock',
		  //   label: 'In stock',
		  //   type: 'integer',
		  //   input: 'radio',
		  //   values: {
		  //     1: 'Yes',
		  //     0: 'No'
		  //   },
		  //   operators: ['equal']
		  // }, {
		  //   id: 'price',
		  //   label: 'Price',
		  //   type: 'double',
		  //   validation: {
		  //     min: 0,
		  //     step: 0.01
		  //   }
		  // }, {
		  //   id: 'id',
		  //   label: 'Identifier',
		  //   type: 'string',
		  //   placeholder: '____-____-____',
		  //   operators: ['equal', 'not_equal'],
		  //   validation: {
		  //     format: /^.{4}-.{4}-.{4}$/
		  //   }
		  // }],

		  // rules: rules_basic
		});

		$('#btn-reset').on('click', function() {
		  $('#builder').queryBuilder('reset');
		});

		$('#btn-set').on('click', function() {
		  $('#builder').queryBuilder('setRules', rules_basic);
		});

		$('#btn-set-sql').on('click', function() {
		  $('#builder-import_export').queryBuilder('setRulesFromSQL', sql_import_export);
		});

		// $('#btn-get').on('click', function() {
		//   var result = $('#builder').queryBuilder('getRules');
		  
		//   if (!$.isEmptyObject(result)) {
		//     alert(JSON.stringify(result, null, 2));
		//   }
		// });

		$('.parse-sql').on('click', function() {
		  var res = $('#builder').queryBuilder('getSQL', $(this).data('stmt'), false);
		  $('#result').removeClass('hide')
		    .find('pre').html(
		      res.sql + (res.params ? '\n\n' + JSON.stringify(res.params, undefined, 2) : '')
		    );
		});

		$('.reset').on('click', function() {
		  $('#builder').queryBuilder('reset');
		  $('#result').addClass('hide').find('pre').empty();
		});

		// $(document).ready(function() { 
		// 	$('#submit').click(function(){

		// 		$('#loading').fadeIn();

		// 		 $.ajax({
		//            type: "POST",
		//            url: 'http://polza.com/app/control/api/control/edit_product.php',
		//            data: $("#form").serialize(), // serializes the form's elements.
		//            success: function(data)
		//            {
		//            }
		// 	         }).done(function() {
		// 			  $('#loading').fadeOut();
		// 			});

		// 	});


		// });
	</script>


</body>
</html>

