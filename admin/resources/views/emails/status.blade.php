<html>
    <head>
        <link rel="stylesheet" href="email.css" >
    <head>
    <body>
        
        <div id="thanks_details">
            <strong><pre>  You can check the status of your order.
                        by logging into your account.
            </pre></strong> 
            
            </div>
            <div id="admin_details">
            <strong>Order Questions?</strong>
            <strong>Call Us:</strong><p>+91-9967471886</p>
            <strong>Email:</strong><p>kumaripri6@gmail.com</p>
         </div>
         <div>
            <strong><p id="order">Your Shipment #</p></strong>
             <p id="order">Order #</p>
             <div id="tb" >
                 <table id="cart_details" style="width:70%;" border="1" >
                    <tr>
                        <th>Tracking code</th>
                        <td> {{$order_id}}</td>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            <p id="bill">BILL TO:</p>
            <div id="address">
                <table style="width:70%;" border="1">
					<tr>
						<th>User address</th>
						<td>{{$productDetails['billing_address']}},{{$productDetails['billing_city']}},{{$productDetails['billing_state']}},{{$productDetails['billing_country']}},{{$productDetails['billing_pincode']}}</td>
					</tr>
					<tr>
						<th>Billing address</th>
						<td>{{$productDetails['billing_address']}},{{$productDetails['billing_city']}},{{$productDetails['billing_state']}},{{$productDetails['billing_country']}},{{$productDetails['billing_pincode']}}</td>
					</tr>
					<tr>
						<th>Shipping address</th>
						<td>{{$productDetails['shipping_address']}},{{$productDetails['shipping_city']}},{{$productDetails['shipping_state']}},{{$productDetails['shipping_country']}},{{$productDetails['shipping_pincode']}}</td>
					</tr>
                </table>
            </div>
            <p id="payment">PAYMENT METHOD:{{$productDetails['shipping_method']}}</p>
         </div>
          
    </body>
</html>
