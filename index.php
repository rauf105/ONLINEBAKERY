<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>project intex</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .header{
          position: fixed;
          top: 0; 
          width: 100%; 
          background-color: gray;
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 30px;

        }
        .header ul li{
            list-style: none;
        }
        .header a{
            text-decoration: none;
            color: white;
        }
        .header li{
            display: inline-block;
            margin-right: 50px;
        }


        .main{
            margin-top: 100px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap ;
            margin-bottom: 90px;
        }
        .product{
            margin: 10px;
            border: 2px solid black;
            max-width: 300px;
            padding: 30px;
            text-align: center;
        }
        
        .product a{
            display: block;
            text-decoration: none;
            color: white;
            background-color: greenyellow;
            padding: 10px;
            margin-top: 10px;
            width: 100%;
        }
        .product img{
            width:150px ;
        }
        .productprice{
            opacity: 70%;
        }
        .footer{
            display: flex;
            flex-direction: row;
            justify-content: center ;
            align-items: center;
            background-color: gray;
            position: fixed;
            bottom: 0;
            padding: 20px;
            width: 100%;
        }
        .footer p{
            text-align: center;
        }
        @media(max-width: 360px){
            .header{
                display: flex;
                flex-direction: column;
            }
            .footer{
                display: flex;
                flex-direction: column;
                background-color: lightblue;
            }
        }

    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">shop</a>
        <a href="index.php"><img scr="" alt=""></a>
        <nav>
            <ul>
                <li><a href="login.php">login</a></li>
                <li><a href="register.php">signup</a></li>
                <li><a href="">dashboard</a></li>
            </ul>
        </nav>

    </header>
    <main class="main">
        <div class="product">
            <img src="productimg/BlackForest.jpg" alt="productimg">
            <h2>product title</h2>
            <p>product description</p>
            <p>product quantity</p>
            <p class="productprice">product price</p>
            <a href="#">Buy Now</a>
        </div>
         <div class="product">
            <img src="productimg/RedVelvet.jpg" alt="productimg">
            <h2>product title</h2>
            <p>product description</p>
            <p>product quantity</p>
            <p class="productprice">product price</p>
            <a href="#">Buy Now</a>
        </div>
        
    </main>
    <footer class="footer">
        <p> copyright@: online bakery
    </footer>

</body>
</html>