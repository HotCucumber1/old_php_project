<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<form action="/add_user.php" method="post" role="form" style="margin-inline: auto; width: 960px">
    <div class="form-group">
        <label for="name">Name:</label>
        <input name="name" id="name" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="last_name">Last_name:</label>
        <input name="last_name" id="last_name" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="middle_name">Middle_name:</label>
        <input name="middle_name" id="middle_name" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="gender">Gender:</label>
        <input name="gender" id="gender" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="birth_date">Birth date:</label>
        <input name="birth_date" id="birth_date" type="date" class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input name="email" id="email" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input name="phone" id="phone" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="avatar_path">Avatar:</label>
        <input name="avatar_path" id="avatar_path" type="text" class="form-control">
    </div>
    <button type="submit">Submit</button>
</form>
</body>
</html>