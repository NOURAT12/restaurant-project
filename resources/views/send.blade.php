
<!DOCTYPE html>
<html>
  <head>
    <title>Verify Your Email Address</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f3f3f3;
  padding: 20px;
  margin: 0;
}
.container {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}
h1 {
  color: #333;
  font-size: 28px;
  margin-bottom: 20px;
}
p {
  color: #666;
  font-size: 16px;
  line-height: 1.5;
  margin-bottom: 20px;
}
.code {
  background-color: #f3f3f3;
  border-radius: 5px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
  display: inline-block;
  font-size: 24px;
  padding: 10px 20px;
}
    </style>
  </head>
  <body>
    <div class="container">
        <h1>Restaurant platform</h1>
      <h2>hello {{$user['name']}} Verify Your Email Address</h2>
      <p>Please enter the following code to verify your email address:</p>
      <div class="code">{{$user['otp']}} </div>
    </div>
  </body>
</html>