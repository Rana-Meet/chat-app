<?php
$msg = "";

if(isset($_POST['login']))
{
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Demo Login
    if($userid == "admin" && $password == "1234")
    {
        $msg = "<div class='success'>Login Successful! Welcome $userid</div>";
    }
    else
    {
        $msg = "<div class='error'>Invalid User ID or Password!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>3D Login Page</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    overflow:hidden;
}

/* Animated Background */
.circle{
    position:absolute;
    border-radius:50%;
    background:rgba(255,255,255,.1);
    animation:move 10s infinite alternate;
}

.circle:nth-child(1){
    width:180px;
    height:180px;
    top:10%;
    left:10%;
}

.circle:nth-child(2){
    width:250px;
    height:250px;
    bottom:10%;
    right:10%;
    animation-duration:15s;
}

@keyframes move{
    from{
        transform:translateY(0) rotate(0deg);
    }
    to{
        transform:translateY(-40px) rotate(360deg);
    }
}

/* Login Card */
.card{
    position:relative;
    width:350px;
    padding:30px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(10px);
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,.5);
    transform-style:preserve-3d;
    animation:float 4s ease-in-out infinite;
}

@keyframes float{
    0%{transform:rotateY(-10deg) translateY(0);}
    50%{transform:rotateY(10deg) translateY(-10px);}
    100%{transform:rotateY(-10deg) translateY(0);}
}

h2{
    color:white;
    text-align:center;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:10px;
    font-size:16px;
}

input:focus{
    outline:none;
    box-shadow:0 0 10px cyan;
}

button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background:#00c6ff;
    color:white;
    font-size:18px;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    transform:scale(1.05);
    background:#0072ff;
}

.success{
    color:#00ff99;
    text-align:center;
    margin-bottom:15px;
    font-weight:bold;
}

.error{
    color:#ff5555;
    text-align:center;
    margin-bottom:15px;
    font-weight:bold;
}
</style>

</head>

<body>

<div class="circle"></div>
<div class="circle"></div>

<div class="card">

<h2>3D Login Page</h2>

<?php echo $msg; ?>

<form method="post">

<input type="text"
name="userid"
placeholder="Enter User ID"
required>

<input type="password"
name="password"
placeholder="Enter Password"
required>

<button type="submit" name="login">
Login
</button>

</form>

</div>

</body>
</html>