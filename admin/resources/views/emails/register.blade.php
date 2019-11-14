<html>
    <head>
        <link rel="stylesheet" href="{{ asset ('/css/email.css')}}" >
       <h1>Welcome to My Shopping Cart.</h1>
       <h5>To log in when visiting our site just clickLoginorMy Accountat the top of every page, and </p>
       <p>then enter your email address and password.</h5>
    <head>
    <body>
        <div id="login_details">
            <p>Use the following values when prompted to log in:<p>
            <p>Email: {{$email}}</p>
            <p>Password: {{$password}}</p>
        </div>
        <div id="steps_login">
            <p>When you log in to your account, you will be able to do the following:</p>
            <ul>
                <li>Proceed through checkout faster when making a purchase</li>
                <li>Check the status of orders</li>
                <li>View past orders</li>
                <li>Make changes to your account information</li>
                <li>Change your password</li>
                <li>Store alternative addresses (for shipping to multiple family members and friends!)</li>
            </ul>
            <p>If you have any questions, please feel free to contact us atinfo@shoppingcompany.como</p>
            <p>by phone at+91 –22 -40500699.</p>
        </div>
    </body>
 </html>
