<title>Best Store a Ecommerce Online Shopping</title>
<!-- for-mobile-apps -->
<base href="http://127.0.0.1:8000/">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="keywords" content="Best Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="template/web/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="template/web/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="template/web/js/jquery.min.js"></script>
<!-- //js -->
<!-- cart -->
<script src="template/web/js/simpleCart.min.js"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="template/web/js/bootstrap-3.1.1.min.js"></script>
<!-- //for bootstrap working -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- timer -->
<link rel="stylesheet" href="template/web/css/jquery.countdown.css" />
<!-- //timer -->
<!-- animation-effect -->
<link href="template/web/css/animate.min.css" rel="stylesheet"> 
<script src="template/web/js/wow.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	function addToCart(e) {
		e.preventDefault();
		let url = $(this).data('url');
		$.ajax({
			type: "GET",
			url: url,       
			dataType: 'json',
			success: function(data) {
				if(data.code === 200) {
					swal("Added to cart !", "You clicked the button!", "success");                   }
			}
		});

	}
	$(document).ready(function() {
		$('.add_to_cart').on('click', addToCart);
	})
</script>
<script src="template/web/js/checkout.js"></script>
<script>
	
	paypal.Button.render({
	  // Configure environment
	  env: 'sandbox',
	  client: {
		sandbox: 'AYaPDHx_2i8YAj5h8VEYraIUPPfDOCH94SIECgCP9E5zMHonUj9KudYNmUDf7Ni-mI4I-vY9MdMjDvsx',
		production: 'demo_production_client_id'
	  },
	  // Customize button (optional)
	  locale: 'en_US',
	  style: {
		size: 'small',
		color: 'gold',
		shape: 'pill',
	  },
  
	  // Enable Pay Now checkout flow (optional)
	  commit: true,
  
	  // Set up a payment
	  payment: function(data, actions) {
		return actions.payment.create({
		  transactions: [{
			amount: {
			  total: '0.01',
			  currency: 'USD'
			}
		  }]
		});
	  },
	  // Execute the payment
	  onAuthorize: function(data, actions) {
		return actions.payment.execute().then(function() {
		  // Show a confirmation message to the buyer
		  window.alert('Thank you for your purchase!');
		});
	  }
	}, '#paypal-button');
  
  </script>