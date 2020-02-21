<!DOCTYPE html>
<html>
<head>
  <title>Unit Details</title>
</head>
<body>
  <table style="width:800px;margin:0 auto;border: solid 1px #ccc;padding: 10px;">
    <tr>
      <td>
        <img src="https://veniceindia.com/public/images/logo.png" style="width: 150px;">
      </td>
    </tr>
    <tr>
      <td>
        <p>Dear <?= $unit_name ?>,</p>
  <p>Your unit has been created on The Grand Venice Units app. Kindly please download the app from the following link and use the following credentials to login:</p>
  <p>App Download Link: <a href="http://shorturl.at/gSZ69">Download</a></p>
  <p>Username: <?= $unit_email ?></p>
  <p>Password: <?= $pin ?></p>
      </td>
    </tr>
  </table>
  

</body>
</html>