<html>
    <head>
        <link rel="stylesheet" href="email.css" >
    <head>
    <body>
        <div id="thanks_details">
            <strong><pre>  THANK YOU FOR YOUR ORDER FROM MY SHOPPING CART.
    FROM MY SHOPPING CART.</pre></strong> 
            <pre>  Once your package ships we will send 
 an email with a link to track your order. 
  Your order summary is below. Thank 
      you again for your business.</pre>
            </div>
            <div id="admin_details">
              <strong>Call Us:</strong><p>+91-9967471886</p>
              <strong>Email:</strong><p>kumaripri6@gmail.com</p>
         </div>
         <div>
            <p id="order">Your order #</p>
            
            <div id="tb" >
              <table id="cart_details" style="width:100%;" border="1" >
                <tr>
                  <th>Serial No</th>
                  <th>Product Id</th>
                  <th>Quantity</th> 
                  <th>Unit Price</th>
                  <th>Total</th>
                </tr>
                @foreach($productDetails['orders'] as $product)
                <tr>
                  <td>{{$product['id']}}</td>
                  <td>{{$product['product_id']}}</td>
                  <td>{{$product['quantity']}}</td>
                  <td>{{$product['amount']}}</td>
                  <td>{{$product['quantity']*$product['amount']}}</td>
                </tr>
                @endforeach
              </table>
            </div>
            <p id="total">Total:Rs.{{$productDetails['grand_total']}}</p>
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
